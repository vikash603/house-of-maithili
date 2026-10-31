@extends('frontend.layout.app')
@section('page-css')<link rel="stylesheet" href="{{ asset('frontend/css/product-detail.css') }}">@endsection
@section('content')
<main class="main hom-payment-page"><div class="container">
    <nav class="hom-product-breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>›</span><a href="{{ route('cart.index') }}">Your bag</a><span>›</span><span>Secure payment</span></nav>
    <section class="hom-payment-card"><div class="hom-payment-brand"><img src="{{ asset('frontend/images/house-of-maithili.png') }}" alt="House Of Maithili"><span>Secure checkout</span></div><p class="hom-detail-eyebrow">ORDER {{ $order->order_number }}</p><h1>Complete your payment</h1><p class="hom-payment-copy">Your order is saved. Razorpay will securely collect your payment details.</p>
        <div class="hom-payment-total"><span>Amount payable</span><strong>₹{{ number_format((float)$order->total, 2) }}</strong></div>
        <div class="hom-payment-alert" id="payment-message" role="status" hidden></div>
        <button type="button" class="hom-checkout-submit" id="razorpay-pay-button">Pay ₹{{ number_format((float)$order->total, 2) }} securely <span aria-hidden="true">→</span></button>
        <p class="hom-checkout-payment-note">Card and UPI details are entered directly in Razorpay Checkout and are never stored on this website.</p>
        <a class="hom-checkout-back" href="{{ route('cart.index') }}">← Return to your bag</a>
    </section>
</div></main>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(() => {
    const button = document.getElementById('razorpay-pay-button');
    const message = document.getElementById('payment-message');
    const showMessage = (text, isError = false) => { message.hidden = false; message.textContent = text; message.classList.toggle('is-error', isError); };
    button.addEventListener('click', () => {
        if (typeof Razorpay === 'undefined') { showMessage('Razorpay Checkout could not load. Check your connection and retry.', true); return; }
        button.disabled = true;
        const checkout = new Razorpay({
            key: @json($razorpayKey),
            amount: {{ (int) $gatewayOrder['amount'] }},
            currency: 'INR',
            name: 'House Of Maithili',
            description: 'Order {{ $order->order_number }}',
            image: @json(asset('frontend/images/house-of-maithili.png')),
            order_id: @json($gatewayOrder['id']),
            prefill: {name: @json($order->customer_name), email: @json($order->email), contact: @json($order->phone)},
            theme: {color: '#6b2432'},
            modal: {ondismiss: () => { button.disabled = false; }},
            handler: async (response) => {
                showMessage('Verifying payment securely…');
                try {
                    const result = await fetch(@json(route('checkout.payment.verify')), {
                        method: 'POST',
                        headers: {'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
                        body: JSON.stringify(response)
                    });
                    const data = await result.json();
                    if (!result.ok || !data.success) throw new Error(data.message || 'Payment verification is still pending.');
                    window.location.assign(data.redirect_url);
                } catch (error) {
                    showMessage(error.message + ' If your account was charged, do not pay again; contact our team with order {{ $order->order_number }}.', true);
                    button.disabled = false;
                }
            }
        });
        checkout.on('payment.failed', (response) => {
            const description = response?.error?.description || 'Payment was not completed.';
            showMessage(description + ' You can retry or choose Cash on Delivery from checkout.', true);
            button.disabled = false;
        });
        checkout.open();
    });
})();
</script>
@endsection
