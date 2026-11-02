<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\User;
use App\Mail\OrderStatusMail;
use App\Notifications\OrderStaffNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class OrderWorkflowService
{
    public const TRANSITIONS = [
        'placed' => ['pending_approval','confirmed','cancelled','cancellation_requested'],
        'pending_approval' => ['confirmed','rejected','cancelled','cancellation_requested'],
        'confirmed' => ['processing','cancelled','cancellation_requested'],
        'processing' => ['packed','cancelled','cancellation_requested'],
        'packed' => ['ready_to_ship','cancelled'],
        'ready_to_ship' => ['shipped'],
        'shipped' => ['in_transit','out_for_delivery','delivered'],
        'in_transit' => ['out_for_delivery','delivered'],
        'out_for_delivery' => ['delivered'],
        'delivered' => ['return_requested'],
        'cancellation_requested' => ['cancelled','confirmed'],
        'return_requested' => ['return_approved','return_rejected'],
        'return_approved' => ['returned'],
        'returned' => ['refund_initiated'],
        'refund_initiated' => ['refunded'],
        'cancelled' => ['refund_initiated'],
        'payment_pending' => ['confirmed','payment_error','cancellation_requested'],
        'payment_error' => ['confirmed','payment_failed','cancellation_requested'],
    ];

    public function transition(Order $order, string $to, ?string $reason, ?int $actorId, bool $internal = false): Order
    {
        return DB::transaction(function () use ($order, $to, $reason, $actorId, $internal) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            if (!in_array($to, self::TRANSITIONS[$locked->status] ?? [], true)) {
                throw ValidationException::withMessages(['status' => 'This order status change is not allowed from its current state.']);
            }
            if (in_array($to, ['confirmed','processing','packed','ready_to_ship','shipped','in_transit','out_for_delivery','delivered'], true)
                && $locked->payment_method === 'razorpay' && $locked->payment_status !== 'paid') {
                throw ValidationException::withMessages(['status' => 'Online orders can only be fulfilled after payment is captured.']);
            }
            if ($to === 'shipped' && (blank($locked->courier_name) || blank($locked->tracking_number))) {
                throw ValidationException::withMessages(['status' => 'Add the real courier and tracking number before marking the parcel dispatched.']);
            }
            if (in_array($to, ['rejected','cancelled','return_rejected'], true) && blank($reason)) {
                throw ValidationException::withMessages(['reason' => 'Please provide a reason for rejecting or cancelling this request.']);
            }

            $from = $locked->status;
            $updates = ['status' => $to];
            if ($to === 'confirmed') { $updates['approved_at'] = now(); $updates['approved_by'] = $actorId; }
            if ($to === 'shipped') $updates['shipped_at'] = now();
            if ($to === 'delivered') $updates['delivered_at'] = now();
            if (str_starts_with($to, 'return_') || $to === 'returned') $updates['return_status'] = $to;
            if ($to === 'refund_initiated') $updates['refund_status'] = 'initiated';
            if ($to === 'refunded') $updates['refund_status'] = 'completed';
            $locked->update($updates);
            OrderEvent::create(['order_id' => $locked->id, 'actor_id' => $actorId, 'type' => 'status', 'from_status' => $from, 'to_status' => $to, 'message' => $reason, 'is_internal' => $internal]);
            DB::afterCommit(fn () => $this->notifyLifecycle($locked->fresh(), $to, $reason));
            return $locked->refresh();
        });
    }

    public function log(Order $order, string $type, ?string $message, ?int $actorId = null, bool $internal = true, array $metadata = []): OrderEvent
    {
        return $order->events()->create(['actor_id' => $actorId, 'type' => $type, 'message' => $message, 'is_internal' => $internal, 'metadata' => $metadata ?: null]);
    }

    private function notifyLifecycle(Order $order, string $status, ?string $reason): void
    {
        $label = str($status)->replace('_',' ')->title()->toString();
        if ($order->email && in_array($status, ['confirmed','rejected','processing','packed','shipped','out_for_delivery','delivered','cancellation_requested','cancelled','return_requested','return_approved','return_rejected','refund_initiated','refunded'], true)) {
            try { Mail::to($order->email)->queue(new OrderStatusMail($order, $label, $reason)); }
            catch (\Throwable $exception) { report($exception); }
        }
        $this->notifyStaff($order, 'Order '.$order->order_number.' moved to '.$label.'.');
    }

    public function notifyStaff(Order $order, string $event): void
    {
        try {
            User::query()->whereNotNull('email_verified_at')->whereRaw('LOWER(TRIM(email)) = ?', [User::AUTHORIZED_ADMIN_EMAIL])
                ->each(fn (User $user) => $user->notify(new OrderStaffNotification($order,$event)));
        } catch (\Throwable $exception) { report($exception); }
    }
}
