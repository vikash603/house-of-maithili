<?php

namespace App\Services;

use App\Mail\AccountAccessCodeMail;
use App\Models\AccountAccessCode;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AccountAccessService
{
    public function sendOrderEmail(Order $order): void
    {
        if (!$order->email) return;

        $order->email = Str::lower(trim($order->email));
        $needsEmailCode = !$order->user_id || $order->account_auto_created_at !== null;
        $code = $needsEmailCode ? $this->newCode($order->email, 'order', $order->id) : null;
        $invoiceUrl = URL::temporarySignedRoute('checkout.invoice', now()->addMonths(6), ['orderNumber' => $order->order_number]);
        $invoicePdfUrl = URL::temporarySignedRoute('checkout.invoice.pdf', now()->addMonths(6), ['orderNumber' => $order->order_number]);

        Mail::to($order->email)->queue(new AccountAccessCodeMail($code, $order, $invoiceUrl, $invoicePdfUrl));
    }

    public function sendLoginCode(string $email): void
    {
        $email = Str::lower(trim($email));
        $code = $this->newCode($email, 'login', null);
        Mail::to($email)->queue(new AccountAccessCodeMail($code));
    }

    public function verify(string $email, string $code, string $purpose, ?int $orderId = null): bool
    {
        $email = Str::lower(trim($email));
        return DB::transaction(function () use ($email, $code, $purpose, $orderId) {
            $query = AccountAccessCode::where('email', $email)->where('purpose', $purpose);
            $orderId === null ? $query->whereNull('order_id') : $query->where('order_id', $orderId);
            $challenge = $query->whereNull('consumed_at')->latest('id')->lockForUpdate()->first();

            if (!$challenge || $challenge->expires_at->isPast() || $challenge->attempts >= 5) return false;

            $challenge->increment('attempts');
            $expected = hash_hmac('sha256', $challenge->email.'|'.$code, (string) config('app.key'));
            if (!hash_equals($challenge->code_hash, $expected)) return false;

            $challenge->update(['consumed_at' => now()]);
            return true;
        });
    }

    private function newCode(string $email, string $purpose, ?int $orderId): string
    {
        if ($orderId === null) {
            AccountAccessCode::where('email', $email)->where('purpose', $purpose)->whereNull('order_id')->whereNull('consumed_at')->update(['consumed_at' => now()]);
        } else {
            AccountAccessCode::where('email', $email)->where('purpose', $purpose)->where('order_id', $orderId)->whereNull('consumed_at')->update(['consumed_at' => now()]);
        }

        $code = (string) random_int(100000, 999999);
        AccountAccessCode::create([
            'order_id' => $orderId,
            'email' => $email,
            'purpose' => $purpose,
            'code_hash' => hash_hmac('sha256', $email.'|'.$code, (string) config('app.key')),
            'expires_at' => now()->addMinutes(10),
        ]);

        return $code;
    }
}
