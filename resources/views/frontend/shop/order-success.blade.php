@extends('frontend.layout.app')
@section('page-css')<link rel="stylesheet" href="{{ asset('frontend/css/product-detail.css') }}">@endsection
@section('content')
<main class="main hom-order-success-page"><div class="container">
    <section class="hom-order-success-card">
        <span class="hom-order-success-icon" aria-hidden="true">✓</span>
        <p class="hom-detail-eyebrow">HOUSE OF MAITHILI</p>
        <h1>{{ $order->payment_method === 'cod' ? 'Your order is placed' : 'Payment received' }}</h1>
        <p>{{ $order->payment_method === 'cod' ? 'Your Cash on Delivery order has been received. Our team will contact you to confirm delivery.' : 'Your payment was verified and your order is confirmed.' }}</p>
        <div class="hom-order-receipt"><span>Order number</span><strong>{{ $order->order_number }}</strong><span>Order total</span><strong>₹{{ number_format((float)$order->total, 2) }}</strong><span>Payment</span><strong>{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Razorpay · Paid' }}</strong></div>
        <a class="hom-checkout-submit hom-invoice-action" href="{{ $invoiceUrl }}" target="_blank" rel="noopener">View / print invoice <span aria-hidden="true">↗</span></a>
        <a class="hom-order-account-link" href="{{ $invoicePdfUrl }}">Download invoice PDF ↓</a>

        @if($canVerifyEmail)
            <div class="hom-order-account-claim">
                <h2>{{ $order->account_auto_created_at ? 'Your profile is ready' : 'Save this order to your account' }}</h2>
                <p>@if($order->account_auto_created_at)Your profile was created using the details from checkout. We sent a one-time code to {{ $order->email }} to verify your email and secure future access. @else We sent a one-time code to {{ $order->email }}. Verify it to sign in to your existing account and save this order there. Your order is already placed; this step is optional. @endif</p>
                @if($isSignedIntoOrderAccount)<div class="hom-account-notice" role="status">You’re already signed in. Your account dashboard is ready.</div><a class="hom-order-account-link" href="{{ route('account.orders.index') }}">Go to my account dashboard →</a>@endif
                @if(session('status'))<div class="hom-account-notice" role="status">{{ session('status') }}</div>@endif
                @if($errors->has('code'))<div class="hom-account-error" role="alert">{{ $errors->first('code') }}</div>@endif
                <form method="POST" action="{{ $verifyUrl }}" class="hom-account-code-form">@csrf
                    <label for="order-account-code">Email verification code</label>
                    <div><input id="order-account-code" name="code" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" required aria-label="Six digit email code"><button type="submit">Verify email &amp; sign in</button></div>
                </form>
                <form method="POST" action="{{ $resendUrl }}" class="hom-account-resend">@csrf<button type="submit">Send a new code</button></form>
                @if($order->account_auto_created_at)<a class="hom-order-account-link" href="{{ route('password.request') }}">Set a password for future sign-ins →</a>@endif
            </div>
        @elseif(auth()->check() && auth()->id() === $order->user_id)
            <p class="hom-account-notice">Your account is ready and this order is saved in your customer account.</p>
            <a class="hom-order-account-link" href="{{ route('account.orders.index') }}">View my orders →</a>
            @if($order->account_auto_created_at)<a class="hom-order-account-link" href="{{ route('password.request') }}">Set a password for future sign-ins →</a>@endif
        @elseif($order->user_id)
            <p class="hom-account-notice">This order is linked to a customer account. Sign in to view it in your order history.</p>
            <a class="hom-order-account-link" href="{{ route('login') }}">Sign in to your account →</a>
        @endif

        <a class="hom-order-continue" href="{{ url('/') }}">Continue shopping <span aria-hidden="true">→</span></a>
        <p class="hom-checkout-payment-note">Order receipt and invoice link sent to {{ $order->email }}.</p>
    </section>
</div></main>
@endsection
