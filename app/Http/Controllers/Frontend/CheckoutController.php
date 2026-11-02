<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderEvent;
use App\Models\User;
use App\Services\AccountAccessService;
use App\Services\RazorpayGateway;
use App\Services\OrderWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class CheckoutController extends Controller
{
    public function index(Request $request, CartController $cartController, RazorpayGateway $gateway)
    {
        $items = $cartController->currentItems($request);
        if ($items->isEmpty()) return redirect()->route('cart.index')->with('cart_error', 'Add a product to your bag before checkout.');

        $subtotal = $items->sum(fn ($item) => $item['unit_price'] * $item['quantity']);
        $couponWasApplied = $request->session()->has('hom_coupon');
        $coupon = $this->activeCoupon($request, $subtotal);
        $discount = $coupon?->discountFor($subtotal) ?? 0;
        if ($couponWasApplied && !$coupon) $request->session()->flash('coupon_error', 'Your coupon is no longer valid for this basket. The updated total is shown below.');
        $razorpayConfigured = $gateway->configured();

        return view('frontend.shop.checkout', compact('items', 'subtotal', 'coupon', 'discount', 'razorpayConfigured'));
    }

    public function applyCoupon(Request $request, CartController $cartController)
    {
        $validated = $request->validate(['coupon_code' => ['required','string','max:40']]);
        $items = $cartController->currentItems($request);
        if ($items->isEmpty()) return redirect()->route('cart.index');
        $subtotal = $items->sum(fn ($item) => $item['unit_price'] * $item['quantity']);
        $code = strtoupper(trim($validated['coupon_code']));
        $coupon = Coupon::currentlyValid()->where('code', $code)->first();

        if (!$coupon) return back()->withInput()->with('coupon_error', 'This coupon is invalid, inactive or outside its valid dates.');
        if ($subtotal < (float) $coupon->minimum_subtotal) {
            $remaining = (float) $coupon->minimum_subtotal - $subtotal;
            return back()->withInput()->with('coupon_error', 'Add ₹'.number_format($remaining, 2).' more to use this coupon.');
        }

        $request->session()->put('hom_coupon', $coupon->code);

        return redirect()->route('checkout.index')->with('coupon_success', 'Coupon '.$coupon->code.' applied.');
    }

    public function removeCoupon(Request $request)
    {
        $request->session()->forget('hom_coupon');

        return redirect()->route('checkout.index')->with('coupon_success', 'Coupon removed.');
    }

    public function placeOrder(Request $request, CartController $cartController, RazorpayGateway $gateway)
    {
        $customer = $request->validate([
            'customer_name' => ['required','string','max:150'],
            'email' => ['required','email','max:190'],
            'phone' => ['required','string','regex:/^[0-9+()\-\s]{8,20}$/'],
            'address' => ['required','string','max:500'],
            'city' => ['required','string','max:120'],
            'state' => ['required','string','max:120'],
            'postal_code' => ['required','string','regex:/^[1-9][0-9]{5}$/'],
            'order_notes' => ['nullable','string','max:1000'],
            'payment_method' => ['required','in:razorpay,cod'],
        ]);
        $customer['email'] = Str::lower(trim($customer['email']));
        $items = $cartController->currentItems($request);
        if ($items->isEmpty()) return redirect()->route('cart.index')->with('cart_error', 'Your bag is empty.');
        $this->validateCurrentStock($items);

        $subtotal = round($items->sum(fn ($item) => $item['unit_price'] * $item['quantity']), 2);
        $couponWasApplied = $request->session()->has('hom_coupon');
        $coupon = $this->activeCoupon($request, $subtotal);
        $discount = $coupon?->discountFor($subtotal) ?? 0;
        if ($couponWasApplied && !$coupon) {
            return redirect()->route('checkout.index')->withInput()->with('coupon_error', 'Your coupon is no longer valid for this order. Please review the updated total.');
        }
        $total = round(max(0, $subtotal - $discount), 2);

        if ($customer['payment_method'] === 'razorpay' && !$gateway->configured()) {
            return back()->withInput()->with('checkout_error', 'Online payment is not configured yet. Please choose Cash on Delivery.');
        }
        if ($customer['payment_method'] === 'razorpay' && $total < 1) {
            return back()->withInput()->with('checkout_error', 'The payable amount is below ₹1. Choose Cash on Delivery for this order.');
        }

        $order = $this->createLocalOrder($customer, $items, $subtotal, $discount, $coupon?->code, $total, $request);
        app(OrderWorkflowService::class)->notifyStaff($order, 'New order '.$order->order_number.' placed; review payment and fulfilment.');

        if ($customer['payment_method'] === 'cod') {
            $request->session()->forget(['hom_cart', 'hom_coupon']);
            $this->queuePostOrderEmail($order, $request, app(AccountAccessService::class));

            return redirect()->to($this->successUrl($order))->with('order_success', 'Your Cash on Delivery order has been placed.');
        }

        try {
            $amountPaise = (int) round($total * 100);
            $gatewayOrder = $gateway->createOrder($amountPaise, $order->order_number, ['internal_order_id' => (string) $order->id]);
            if (empty($gatewayOrder['id']) || (int) ($gatewayOrder['amount'] ?? 0) !== $amountPaise || ($gatewayOrder['currency'] ?? '') !== 'INR') {
                throw new \RuntimeException('Razorpay returned an invalid order response.');
            }
            $order->update(['razorpay_order_id' => $gatewayOrder['id'], 'status' => 'payment_pending']);
        } catch (Throwable $exception) {
            report($exception);
            $order->update(['status' => 'payment_error', 'payment_status' => 'failed']);
            OrderEvent::create(['order_id' => $order->id, 'type' => 'payment', 'from_status' => 'pending', 'to_status' => 'failed', 'message' => 'Online payment could not be started.', 'is_internal' => false]);
            app(OrderWorkflowService::class)->notifyStaff($order->fresh(), 'Online payment could not start for order '.$order->order_number.'.');

            return back()->withInput()->with('checkout_error', 'Razorpay could not start the payment. Please retry or choose Cash on Delivery.');
        }

        return view('frontend.shop.razorpay', [
            'order' => $order,
            'gatewayOrder' => $gatewayOrder,
            'razorpayKey' => $gateway->keyId(),
        ]);
    }

    public function verifyPayment(Request $request, RazorpayGateway $gateway)
    {
        $data = $request->validate([
            'razorpay_order_id' => ['required','string','max:80'],
            'razorpay_payment_id' => ['required','string','max:80'],
            'razorpay_signature' => ['required','string','size:64'],
        ]);
        $order = Order::where('razorpay_order_id', $data['razorpay_order_id'])->firstOrFail();

        if ($order->payment_status === 'paid' && $order->razorpay_payment_id === $data['razorpay_payment_id']) {
            $this->queuePostOrderEmail($order, $request, app(AccountAccessService::class));
            $request->session()->forget(['hom_cart', 'hom_coupon']);
            return response()->json(['success' => true, 'redirect_url' => $this->successUrl($order)]);
        }

        if (!$gateway->verifyCheckoutSignature($order->razorpay_order_id, $data['razorpay_payment_id'], $data['razorpay_signature'])) {
            return response()->json(['message' => 'Payment verification failed. Please contact our support team.'], 422);
        }

        try {
            $payment = $gateway->fetchPayment($data['razorpay_payment_id']);
            if (($payment['order_id'] ?? null) !== $order->razorpay_order_id
                || (int) ($payment['amount'] ?? 0) !== (int) round((float) $order->total * 100)
                || ($payment['currency'] ?? '') !== 'INR') {
                return response()->json(['message' => 'The payment details do not match this order. Please contact support.'], 422);
            }
            if (($payment['status'] ?? '') === 'authorized') {
                $payment = $gateway->capturePayment($data['razorpay_payment_id'], (int) round((float) $order->total * 100));
            }
            if (($payment['status'] ?? '') !== 'captured' && empty($payment['captured'])) {
                return response()->json(['message' => 'Payment is not captured yet. Please retry or contact support.'], 422);
            }
        } catch (Throwable $exception) {
            report($exception);

            return response()->json(['message' => 'We could not confirm the payment status yet. Please wait a moment and retry.'], 503);
        }

        if (!$this->markOrderPaid($order, $data['razorpay_payment_id'])) {
            return response()->json(['message' => 'This order has already been paid with a different transaction. Please contact support.'], 409);
        }
        app(OrderWorkflowService::class)->notifyStaff($order->fresh(), 'Payment captured for order '.$order->order_number.'.');
        $this->queuePostOrderEmail($order, $request, app(AccountAccessService::class));
        $request->session()->forget(['hom_cart', 'hom_coupon']);

        return response()->json(['success' => true, 'redirect_url' => $this->successUrl($order)]);
    }

    public function webhook(Request $request, RazorpayGateway $gateway)
    {
        $rawBody = $request->getContent();
        $signature = (string) $request->header('X-Razorpay-Signature');
        if (!$gateway->verifyWebhookSignature($rawBody, $signature)) return response('Invalid signature', 400);

        $payload = json_decode($rawBody, true);
        if (!is_array($payload)) return response('Invalid payload', 400);

        $event = $payload['event'] ?? '';
        $payment = $payload['payload']['payment']['entity'] ?? null;
        if (!is_array($payment) || empty($payment['order_id'])) return response('Ignored', 200);

        $order = Order::where('razorpay_order_id', $payment['order_id'])->first();
        if (!$order) return response('Order not found', 200);

        if (in_array($event, ['payment.captured', 'order.paid'], true)) {
            if ((int) ($payment['amount'] ?? 0) !== (int) round((float) $order->total * 100) || ($payment['currency'] ?? '') !== 'INR') {
                return response('Payment amount mismatch', 400);
            }
            if ($order->payment_status !== 'paid' && $this->markOrderPaid($order, (string) $payment['id'])) {
                app(OrderWorkflowService::class)->notifyStaff($order->fresh(), 'Payment captured for order '.$order->order_number.'.');
                $this->queuePostOrderEmail($order, $request, app(AccountAccessService::class), false);
            }
        } elseif ($event === 'payment.failed' && $order->payment_status !== 'paid') {
            $newFailure = $order->payment_status !== 'failed';
            $order->update(['payment_status' => 'failed']);
            OrderEvent::firstOrCreate(['order_id'=>$order->id,'type'=>'payment','to_status'=>'failed','message'=>'Payment provider reported a failed attempt.'], ['from_status'=>$order->status,'is_internal'=>false,'metadata'=>['provider'=>'razorpay']]);
            if ($newFailure) app(OrderWorkflowService::class)->notifyStaff($order, 'Payment failed for order '.$order->order_number.'.');
        }

        return response('OK', 200);
    }

    public function success(Request $request, string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        $invoiceUrl = $this->invoiceUrl($order);
        $invoicePdfUrl = URL::temporarySignedRoute('checkout.invoice.pdf', now()->addMonths(6), ['orderNumber' => $order->order_number]);
        $verifyUrl = URL::temporarySignedRoute('checkout.account.verify', now()->addMinutes(30), ['orderNumber' => $order->order_number]);
        $resendUrl = URL::temporarySignedRoute('checkout.account.resend', now()->addMinutes(30), ['orderNumber' => $order->order_number]);
        $canVerifyEmail = !$order->user_id || ($order->account_auto_created_at && !$order->user?->email_verified_at);
        $isSignedIntoOrderAccount = auth()->check() && auth()->id() === $order->user_id;

        return view('frontend.shop.order-success', compact('order', 'invoiceUrl', 'invoicePdfUrl', 'verifyUrl', 'resendUrl', 'canVerifyEmail', 'isSignedIntoOrderAccount'));
    }

    private function createLocalOrder(array $customer, $items, float $subtotal, float $discount, ?string $couponCode, float $total, Request $request): Order
    {
        return DB::transaction(function () use ($customer, $items, $subtotal, $discount, $couponCode, $total, $request) {
            do {
                $orderNumber = 'HOM-'.now()->format('ymd').'-'.Str::upper(Str::random(7));
            } while (Order::where('order_number', $orderNumber)->exists());

            $isCod = $customer['payment_method'] === 'cod';
            $attribution = (array) $request->session()->get('hom_attribution', []);
            $source = $this->orderSource($attribution);
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'customer_name' => $customer['customer_name'],
                'email' => $customer['email'] ?? null,
                'phone' => $customer['phone'],
                'address' => $customer['address'],
                'city' => $customer['city'],
                'state' => $customer['state'],
                'postal_code' => $customer['postal_code'],
                'order_notes' => $customer['order_notes'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'coupon_code' => $couponCode,
                'total' => $total,
                'currency' => 'INR',
                'payment_method' => $customer['payment_method'],
                'payment_status' => $isCod ? 'pending_cod' : 'pending',
                'status' => $isCod ? 'pending_approval' : 'payment_pending',
                'source' => $source,
                'utm_source' => $attribution['utm_source'] ?? null,
                'utm_medium' => $attribution['utm_medium'] ?? null,
                'utm_campaign' => $attribution['utm_campaign'] ?? null,
                'utm_content' => $attribution['utm_content'] ?? null,
                'referrer_url' => $attribution['referrer_url'] ?? null,
            ]);
            OrderEvent::create(['order_id'=>$order->id,'type'=>'order_placed','from_status'=>null,'to_status'=>$order->status,'message'=>'Order received.','is_internal'=>false,'metadata'=>['source'=>$source]]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_variant_id' => $item['variant']?->id,
                    'product_name' => $item['product']->name,
                    'sku' => $item['variant']?->sku ?: $item['product']->sku,
                    'size' => $item['variant']?->size,
                    'color' => $item['variant']?->color,
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'line_total' => round($item['unit_price'] * $item['quantity'], 2),
                ]);
            }

            return $order;
        });
    }

    private function markOrderPaid(Order $order, string $paymentId): bool
    {
        return DB::transaction(function () use ($order, $paymentId) {
            $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            if ($lockedOrder->payment_status === 'paid') {
                if ($lockedOrder->razorpay_payment_id !== $paymentId) logger()->warning('A different payment was reported for an already paid order.', ['order_number' => $lockedOrder->order_number, 'payment_id' => $paymentId]);
                return $lockedOrder->razorpay_payment_id === $paymentId;
            }
            $fromStatus = $lockedOrder->status;
            $lockedOrder->update([
                'razorpay_payment_id' => $paymentId,
                'payment_status' => 'paid',
                'status' => $lockedOrder->status === 'payment_pending' ? 'pending_approval' : $lockedOrder->status,
                'paid_at' => now(),
            ]);
            OrderEvent::create(['order_id'=>$lockedOrder->id,'type'=>'payment','from_status'=>'pending','to_status'=>'paid','message'=>'Payment captured successfully.','is_internal'=>false,'metadata'=>['provider'=>'razorpay']]);
            if ($fromStatus === 'payment_pending') OrderEvent::create(['order_id'=>$lockedOrder->id,'type'=>'status','from_status'=>$fromStatus,'to_status'=>'pending_approval','message'=>'Payment captured; order is awaiting fulfilment review.','is_internal'=>false]);

            return true;
        });
    }

    private function orderSource(array $attribution): string
    {
        $utm = strtolower((string) ($attribution['utm_source'] ?? ''));
        $referrer = strtolower((string) ($attribution['referrer_url'] ?? ''));
        $candidate = $utm ?: $referrer;
        foreach (['google'=>'Google','facebook'=>'Facebook','instagram'=>'Instagram','whatsapp'=>'WhatsApp','mail.google'=>'Email Campaign','email'=>'Email Campaign'] as $needle => $label) {
            if ($candidate !== '' && str_contains($candidate, $needle)) return $label;
        }
        if ($utm !== '') return 'Other Campaign';
        if ($referrer !== '') return 'Referral';
        return 'Direct';
    }

    private function validateCurrentStock($items): void
    {
        foreach ($items as $item) {
            if ($item['product']->is_made_to_order) continue;
            $available = $item['variant']?->stock ?? $item['product']->stock;
            if ($available < $item['quantity']) {
                throw ValidationException::withMessages(['quantity' => $item['product']->name.' no longer has enough ready stock. Please update your bag.']);
            }
        }
    }

    private function successUrl(Order $order): string
    {
        return URL::temporarySignedRoute('checkout.success', now()->addDays(7), ['orderNumber' => $order->order_number]);
    }

    private function invoiceUrl(Order $order): string
    {
        return URL::temporarySignedRoute('checkout.invoice', now()->addMonths(6), ['orderNumber' => $order->order_number]);
    }

    private function queuePostOrderEmail(Order $order, Request $request, AccountAccessService $access, bool $allowLogin = true): void
    {
        if (!$order->email) return;

        $this->createCustomerAccountAfterOrder($order, $request, $allowLogin);
        $order->refresh();
        if ($order->account_email_sent_at) return;

        $reserved = DB::transaction(function () use ($order) {
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            if ($locked->account_email_sent_at) return false;
            $locked->update(['account_email_sent_at' => now()]);
            return true;
        });

        if (!$reserved) return;

        try {
            $access->sendOrderEmail($order->fresh());
        } catch (Throwable $exception) {
            Order::whereKey($order->id)->update(['account_email_sent_at' => null]);
            report($exception);
        }
    }

    private function createCustomerAccountAfterOrder(Order $order, Request $request, bool $allowLogin): void
    {
        $order->refresh();
        if (!$order->user_id && $order->email && !User::where('email', $order->email)->exists()) {
            try {
                DB::transaction(function () use ($order) {
                    if (User::where('email', $order->email)->exists()) return;

                    $user = User::create([
                        'name' => $order->customer_name,
                        'email' => $order->email,
                        'phone' => $order->phone,
                        'password' => Str::random(64),
                    ]);

                    $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
                    if (!$lockedOrder->user_id) {
                        $lockedOrder->update(['user_id' => $user->id, 'account_auto_created_at' => now()]);
                    }
                });
            } catch (Throwable $exception) {
                // The order must remain successful even if account provisioning encounters a race or database issue.
                report($exception);
            }
        }

        $order->refresh();
        if (!$allowLogin || !$order->account_auto_created_at || !$order->user_id) return;

        $user = User::find($order->user_id);
        if ($user && (!Auth::check() || Auth::id() === $user->id)) {
            Auth::login($user, true);
            $request->session()->regenerate();
        }
    }

    private function activeCoupon(Request $request, float $subtotal): ?Coupon
    {
        $code = $request->session()->get('hom_coupon');
        if (!$code) return null;

        $coupon = Coupon::currentlyValid()->where('code', $code)->first();
        if (!$coupon || $subtotal < (float) $coupon->minimum_subtotal) {
            $request->session()->forget('hom_coupon');
            return null;
        }

        return $coupon;
    }
}
