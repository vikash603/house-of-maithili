@extends('frontend.layout.app')
@section('page-css')<link rel="stylesheet" href="{{ asset('frontend/css/product-detail.css') }}">@endsection
@section('content')
<main class="main hom-checkout-page"><div class="container">
    <nav class="hom-product-breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>›</span><a href="{{ route('cart.index') }}">Your bag</a><span>›</span><span>Checkout</span></nav>
    <header class="hom-cart-heading"><p class="hom-detail-eyebrow">HOUSE OF MAITHILI</p><h1>Checkout</h1><p>Share your delivery details and review your order before contacting our team.</p></header>
    @if(session('cart_success'))<div class="hom-cart-notice" role="status">{{ session('cart_success') }}</div>@endif
    @if(session('checkout_error'))<div class="hom-cart-error" role="alert">{{ session('checkout_error') }}</div>@endif

    <div class="hom-checkout-layout">
        <section class="hom-checkout-details">
            @if($errors->any())<div class="hom-cart-error" role="alert">{{ $errors->first() }}</div>@endif
            @if(session('coupon_error'))<div class="hom-cart-error" role="alert">{{ session('coupon_error') }}</div>@endif
            @if(session('coupon_success'))<div class="hom-cart-notice" role="status">{{ session('coupon_success') }}</div>@endif
            <form method="POST" action="{{ route('checkout.place-order') }}" id="checkout-form">@csrf
                <section class="hom-checkout-card"><div class="hom-checkout-card-title"><span>01</span><div><h2>Contact details</h2><p>We will use these details to confirm your order.</p></div></div>
                    <div class="hom-checkout-fields">
                        <div class="hom-checkout-field hom-field-full"><label for="customer-name">Full name <b>*</b></label><input id="customer-name" name="customer_name" value="{{ old('customer_name') }}" autocomplete="name" required maxlength="150"></div>
                        <div class="hom-checkout-field"><label for="customer-phone">Mobile number <b>*</b></label><input id="customer-phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" required maxlength="20" placeholder="+91"></div>
                        <div class="hom-checkout-field"><label for="customer-email">Email address <b>*</b></label><input id="customer-email" name="email" type="email" value="{{ old('email', auth()->user()?->email) }}" autocomplete="email" required maxlength="190"></div>
                    </div>
                </section>
                <section class="hom-checkout-card"><div class="hom-checkout-card-title"><span>02</span><div><h2>Delivery address</h2><p>Enter the address where you would like your order delivered.</p></div></div>
                    <div class="hom-checkout-fields">
                        <div class="hom-checkout-field hom-field-full"><label for="delivery-address">Address <b>*</b></label><textarea id="delivery-address" name="address" rows="3" autocomplete="street-address" required maxlength="500">{{ old('address') }}</textarea></div>
                        <div class="hom-checkout-field"><label for="delivery-city">City <b>*</b></label><input id="delivery-city" name="city" value="{{ old('city') }}" autocomplete="address-level2" required maxlength="120"></div>
                        <div class="hom-checkout-field"><label for="delivery-state">State <b>*</b></label><input id="delivery-state" name="state" value="{{ old('state') }}" autocomplete="address-level1" required maxlength="120"></div>
                        <div class="hom-checkout-field"><label for="delivery-postal">PIN code <b>*</b></label><input id="delivery-postal" name="postal_code" inputmode="numeric" value="{{ old('postal_code') }}" autocomplete="postal-code" pattern="[1-9][0-9]{5}" required maxlength="6"></div>
                        <div class="hom-checkout-field hom-field-full"><label for="order-notes">Order notes <span>(optional)</span></label><textarea id="order-notes" name="order_notes" rows="2" maxlength="1000" placeholder="Anything our team should know?">{{ old('order_notes') }}</textarea></div>
                    </div>
                </section>
            </form>
            <div class="hom-checkout-security"><span aria-hidden="true">✧</span><p>After your order is placed, we’ll create your customer profile using your name, email and mobile number, then sign you in automatically. We’ll email a one-time code so you can verify your profile for future sign-ins. Password sign-in is also available.</p></div>
        </section>

        <aside class="hom-checkout-summary">
            <section class="hom-checkout-card hom-checkout-order-card"><h2>Your order</h2>
                <div class="hom-checkout-line-items">@foreach($items as $item)<div class="hom-checkout-line-item"><div><strong>{{ $item['product']->name }}</strong>@if($item['variant'])<small>{{ collect([$item['variant']->size, $item['variant']->color])->filter()->join(' · ') }}</small>@endif<small>Qty {{ $item['quantity'] }}</small></div><span>₹{{ number_format($item['unit_price'] * $item['quantity'], 2) }}</span></div>@endforeach</div>
                <form class="hom-coupon-form" method="POST" action="{{ route('checkout.coupon.apply') }}">@csrf<label for="coupon-code">Coupon code</label><div><input id="coupon-code" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Enter code" maxlength="40" autocomplete="off"><button type="submit">Apply</button></div></form>
                @if($coupon)<div class="hom-applied-coupon"><span><b>{{ $coupon->code }}</b> applied</span><form method="POST" action="{{ route('checkout.coupon.remove') }}">@csrf @method('DELETE')<button type="submit" aria-label="Remove coupon">Remove</button></form></div>@endif
                <div class="hom-checkout-totals"><div><span>Subtotal</span><strong>₹{{ number_format($subtotal, 2) }}</strong></div>@if($coupon)<div class="hom-discount-line"><span>Discount ({{ $coupon->code }})</span><strong>−₹{{ number_format($discount, 2) }}</strong></div>@endif<div><span>Delivery</span><small>Confirmed by our team</small></div><div class="hom-checkout-total"><span>Total before delivery</span><strong>₹{{ number_format($subtotal - $discount, 2) }}</strong></div></div>
                @php($canRazorpay = $razorpayConfigured && ($subtotal - $discount) >= 1)
                <fieldset class="hom-payment-methods"><legend>Payment method</legend>
                    <label class="hom-payment-choice"><input type="radio" name="payment_method" value="razorpay" form="checkout-form" @checked(old('payment_method', $canRazorpay ? 'razorpay' : 'cod') === 'razorpay') @disabled(!$canRazorpay)><span><strong>Pay online with Razorpay</strong><small>UPI, cards, netbanking and other enabled methods</small></span><b>Secure</b></label>
                    <label class="hom-payment-choice"><input type="radio" name="payment_method" value="cod" form="checkout-form" @checked(old('payment_method', $canRazorpay ? 'razorpay' : 'cod') === 'cod')><span><strong>Cash on Delivery</strong><small>Pay when your order is delivered</small></span></label>
                </fieldset>
                @if(!$razorpayConfigured)<p class="hom-checkout-payment-note">Online payments are being configured. Cash on Delivery is available.</p>@elseif(($subtotal - $discount) < 1)<p class="hom-checkout-payment-note">Online payment requires a payable total of at least ₹1. Cash on Delivery is available.</p>@endif
                <button class="hom-checkout-submit" id="checkout-submit" type="submit" form="checkout-form">{{ old('payment_method', $canRazorpay ? 'razorpay' : 'cod') === 'cod' ? 'Place COD order' : 'Pay securely with Razorpay' }} <span aria-hidden="true">→</span></button>
                <p class="hom-checkout-payment-note">Your order and selected payment method will be saved securely before confirmation.</p>
            </section>
            <a class="hom-checkout-back" href="{{ route('cart.index') }}">← Return to your bag</a>
        </aside>
    </div>
</div></main>
<script>
document.querySelectorAll('input[name="payment_method"]').forEach((input) => input.addEventListener('change', () => {
    document.getElementById('checkout-submit').innerHTML = input.value === 'cod' ? 'Place COD order <span aria-hidden="true">→</span>' : 'Pay securely with Razorpay <span aria-hidden="true">→</span>';
}));
</script>
@endsection
