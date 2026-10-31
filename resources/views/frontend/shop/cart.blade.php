@extends('frontend.layout.app')
@section('page-css')<link rel="stylesheet" href="{{ asset('frontend/css/product-detail.css') }}">@endsection
@section('content')
<main class="main hom-cart-page"><div class="container">
    <nav class="hom-product-breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>›</span><span>Your bag</span></nav>
    <header class="hom-cart-heading"><p class="hom-detail-eyebrow">HOUSE OF MAITHILI</p><h1>Your Shopping Bag</h1><p>Review your handcrafted pieces before placing your order.</p></header>
    @if(session('cart_success'))<div class="hom-cart-notice" role="status">{{ session('cart_success') }}</div>@endif
    @if(session('cart_error'))<div class="hom-cart-error" role="alert">{{ session('cart_error') }}</div>@endif
    @if($errors->any())<div class="hom-cart-error" role="alert">{{ $errors->first() }}</div>@endif
    @if($items->isEmpty())
        <section class="hom-cart-empty"><span aria-hidden="true">♡</span><h2>Your bag is waiting</h2><p>Discover handcrafted clothing and home pieces made with care.</p><a href="{{ url('/') }}#maithili-bestsellers">Explore the collection</a></section>
    @else
        <div class="hom-cart-layout"><section class="hom-cart-items" aria-label="Items in your bag">
            @foreach($items as $item)
                <article class="hom-cart-item">
                    <a class="hom-cart-item-image" href="{{ route('shop.products.show', $item['product']->slug) }}">@if($item['product']->thumbnail && is_file(public_path('uploads/products/'.$item['product']->thumbnail)))<img src="{{ asset('uploads/products/'.$item['product']->thumbnail) }}" alt="{{ $item['product']->name }}">@else<div>House Of Maithili</div>@endif</a>
                    <div class="hom-cart-item-detail"><a href="{{ route('shop.products.show', $item['product']->slug) }}"><h2>{{ $item['product']->name }}</h2></a>@if($item['variant'])<p>{{ collect([$item['variant']->size, $item['variant']->color])->filter()->join(' · ') }}</p>@endif<p class="hom-cart-item-sku">{{ $item['product']->is_made_to_order ? 'Made to order' : 'Handcrafted in Bihar' }}</p>
                        <div class="hom-cart-mobile-price">₹{{ number_format($item['unit_price'], 2) }}</div>
                        <div class="hom-cart-item-actions"><form method="POST" action="{{ route('cart.update', $item['key']) }}">@csrf @method('PATCH')<label class="visually-hidden" for="quantity-{{ $loop->index }}">Quantity for {{ $item['product']->name }}</label><input id="quantity-{{ $loop->index }}" type="number" name="quantity" min="1" max="20" value="{{ $item['quantity'] }}"><button type="submit">Update</button></form><form method="POST" action="{{ route('cart.remove', $item['key']) }}">@csrf @method('DELETE')<button type="submit" class="hom-cart-remove">Remove</button></form></div>
                    </div>
                    <strong class="hom-cart-line-price">₹{{ number_format($item['unit_price'] * $item['quantity'], 2) }}</strong>
                </article>
            @endforeach
        </section><aside class="hom-cart-summary"><h2>Order summary</h2><div><span>Subtotal · {{ $cartCount }} {{ $cartCount === 1 ? 'item' : 'items' }}</span><strong>₹{{ number_format($subtotal, 2) }}</strong></div><p>Apply available coupon codes at checkout. Delivery charges are confirmed by our team.</p><a class="hom-cart-checkout" href="{{ route('checkout.index') }}">Proceed to checkout <span aria-hidden="true">→</span></a><a class="hom-cart-continue" href="{{ url('/') }}#maithili-bestsellers">Continue shopping</a></aside></div>
    @endif
</div></main>
@endsection
