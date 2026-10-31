@extends('frontend.layout.app')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('frontend/css/product-detail.css') }}">
@endsection
@section('content')
@php
    $mainProductImage = $product->thumbnail && is_file(public_path('uploads/products/'.$product->thumbnail))
        ? asset('uploads/products/'.$product->thumbnail)
        : ($product->images->first() && is_file(public_path('uploads/products/'.$product->images->first()->image)) ? asset('uploads/products/'.$product->images->first()->image) : null);
@endphp
<main class="main hom-product-detail">
    <div class="container">
        <nav class="hom-product-breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>›</span><a href="{{ route('shop.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a><span>›</span><span>{{ $product->name }}</span></nav>

        <div class="hom-product-layout">
            <section class="hom-product-gallery" aria-label="Product images">
                <div class="hom-product-thumbnails" role="list" aria-label="Choose product image">
                    @if($mainProductImage)
                        <button class="hom-thumb is-selected" type="button" data-image="{{ $mainProductImage }}" aria-label="Show main product image"><img src="{{ $mainProductImage }}" alt=""></button>
                    @endif
                    @foreach($product->images as $image)
                        @if(is_file(public_path('uploads/products/'.$image->image)))<button class="hom-thumb" type="button" data-image="{{ asset('uploads/products/'.$image->image) }}" aria-label="Show product detail image"><img src="{{ asset('uploads/products/'.$image->image) }}" alt=""></button>@endif
                    @endforeach
                </div>
                <div class="hom-product-image-stage">
                    @if($mainProductImage)<img id="hom-main-image" src="{{ $mainProductImage }}" alt="{{ $product->name }}">@else<div class="hom-product-image-empty">House Of Maithili</div>@endif
                </div>
            </section>

            <section class="hom-product-summary">
                <div class="hom-detail-badges"><span>{{ $product->is_made_to_order ? 'Made to order' : 'Handcrafted in Bihar' }}</span>@if($product->is_featured)<span class="hom-detail-featured">House edit</span>@endif</div>
                <p class="hom-detail-eyebrow">{{ $product->brand ?: 'HOUSE OF MAITHILI' }} · {{ $product->category->name }}</p>
                <h1>{{ $product->name }}</h1>
                @if($product->short_description)<p class="hom-detail-subtitle">{{ $product->short_description }}</p>@endif
                <div class="hom-detail-price"><strong id="selected-price">₹{{ number_format((float)($product->sale_price ?: $product->price), 2) }}</strong><del id="selected-original-price" @if(!$product->sale_price) hidden @endif>₹{{ number_format((float)$product->price, 2) }}</del></div>
                <p class="hom-detail-tax">Inclusive of all taxes</p>
                @if($product->description)<div class="hom-detail-description">{{ $product->description }}</div>@endif

                <div class="hom-product-assurances" aria-label="Product values">
                    <div><svg class="hom-assurance-icon" viewBox="0 0 40 40" aria-hidden="true"><path d="M31 7C17 7 9 13 9 23c0 6 5 10 10 10 10 0 12-13 12-26Z"/><path d="M7 34c6-8 12-13 21-19"/></svg><span>Handcrafted<br>in Bihar</span></div>
                    <div><svg class="hom-assurance-icon" viewBox="0 0 40 40" aria-hidden="true"><path d="M13 20V9a2 2 0 0 1 4 0v9-12a2 2 0 0 1 4 0v12-10a2 2 0 0 1 4 0v11-7a2 2 0 0 1 4 0v11c0 8-4 12-11 12-5 0-8-3-10-8l-3-7a2 2 0 0 1 4-2l4 5Z"/></svg><span>Made by women<br>artisans</span></div>
                    <div><svg class="hom-assurance-icon" viewBox="0 0 40 40" aria-hidden="true"><path d="M20 34V20M20 24C9 24 7 17 7 12c8 0 13 4 13 12ZM20 21c0-9 5-14 13-14 0 8-4 14-13 14ZM13 34h14M17 30h6"/></svg><span>Made to order<br>with care</span></div>
                    <div><svg class="hom-assurance-icon" viewBox="0 0 40 40" aria-hidden="true"><path d="M20 34V19M20 24c-8 0-12-5-12-11 7 0 12 4 12 11ZM20 20c0-8 5-13 12-13 0 7-4 13-12 13Z"/></svg><span>Sustainable<br>&amp; ethical</span></div>
                </div>

                @if($product->is_made_to_order)
                    <div class="hom-made-to-order"><span class="hom-made-icon" aria-hidden="true">◷</span><div><strong>Made especially for you</strong><span>Please allow {{ $product->lead_time_days ?: 15 }} working days for crafting and dispatch.</span></div></div>
                @endif

                @if($product->variants->isNotEmpty())
                    <div class="hom-variant-picker"><div class="hom-variant-heading"><label>Choose your size / colour</label><span class="hom-variant-tools"><small>{{ $product->variants->where('is_active', true)->count() }} options</small><button type="button" class="hom-size-guide-trigger" id="size-guide-open">Size Guide</button></span></div><div class="hom-variant-options" aria-label="Product size and colour">
                        @foreach($product->variants as $variant)
                            @php($optionLabel = collect([$variant->size, $variant->color])->filter()->join(' · '))
                            <button type="button" class="hom-variant-option" aria-pressed="false" data-id="{{ $variant->id }}" data-label="{{ $optionLabel }}" data-price="{{ $variant->sale_price ?: $variant->price ?: $product->sale_price ?: $product->price }}" data-original="{{ $variant->price ?: $product->price }}" data-stock="{{ $variant->stock }}" data-sku="{{ $variant->sku }}" @disabled(!$variant->is_active || (!$product->is_made_to_order && $variant->stock < 1))>{{ $optionLabel }}@if(!$variant->is_active || (!$product->is_made_to_order && $variant->stock < 1)) · Unavailable @endif</button>
                        @endforeach
                    </div><small id="variant-availability" aria-live="polite">{{ $product->variants->where('is_active', true)->isEmpty() ? 'No options are currently available.' : 'Select an option to see availability.' }}</small></div>
                @else
                    <div class="hom-detail-availability">{{ $product->stock > 0 ? $product->stock.' available' : ($product->is_made_to_order ? 'Crafted after you order' : 'Currently unavailable') }}</div>
                @endif

                @if(session('cart_success'))<div class="hom-cart-notice" role="status">{{ session('cart_success') }} <a href="{{ route('cart.index') }}">View bag</a></div>@endif
                @if($errors->any())<div class="hom-cart-error" role="alert">{{ $errors->first() }}</div>@endif
                @php($purchaseUnavailable = !$product->is_made_to_order && $product->stock < 1 && $product->variants->isEmpty())
                <form class="hom-purchase-form" id="product-purchase-form" method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="variant_id" id="selected-variant-id" value="">
                    <div class="hom-purchase-controls">
                        <label class="hom-quantity-label" for="product-quantity">Quantity</label>
                        <div class="hom-quantity-control"><button type="button" id="quantity-minus" aria-label="Decrease quantity">−</button><input id="product-quantity" type="number" name="quantity" value="1" min="1" max="20" inputmode="numeric" aria-label="Quantity"><button type="button" id="quantity-plus" aria-label="Increase quantity">+</button></div>
                        <div class="hom-purchase-buttons"><button class="hom-add-to-cart" id="add-to-cart-button" type="submit" @disabled($purchaseUnavailable || $product->variants->isNotEmpty())>Add to Cart</button><button class="hom-buy-now" id="buy-now-button" type="submit" formaction="{{ route('cart.buy-now') }}" @disabled($purchaseUnavailable || $product->variants->isNotEmpty())>Buy Now</button></div>
                    </div>
                </form>
                <div class="hom-contact-actions">
                    <a class="hom-whatsapp-link" id="product-whatsapp-link" target="_blank" rel="noopener" href="https://wa.me/{{ preg_replace('/\D+/', '', (string) config('services.house_of_maithili_whatsapp')) }}?text={{ rawurlencode('Namaste House Of Maithili, I would like to know more about '.$product->name.'.') }}"><span aria-hidden="true">◉</span> Chat on WhatsApp</a>
                    <a class="hom-team-link" href="mailto:info@houseofmaithili.com?subject={{ rawurlencode('Product enquiry: '.$product->name) }}"><span aria-hidden="true">✉</span> Ask Our Team</a>
                </div>
                <p class="hom-detail-note">Need help choosing? Our team would be happy to guide you.</p>
            </section>
        </div>

        <dialog class="hom-size-guide" id="hom-size-guide" aria-labelledby="hom-size-guide-title"><div class="hom-size-guide-header"><h2 id="hom-size-guide-title">Size guidance</h2><button type="button" id="size-guide-close" aria-label="Close size guide">×</button></div><p>Choose the size that you usually wear. For a made-to-order piece or a closer fit, our team can guide you using your bust, waist and hip measurements.</p><a href="mailto:info@houseofmaithili.com?subject={{ rawurlencode('Size guidance: '.$product->name) }}">Ask our team for size help</a></dialog>

        <section class="hom-product-story" aria-label="Product and delivery information">
            <div class="hom-story-size"><h2>Crafted for your choice</h2><p>Choose the option that feels right for you. Each piece is finished with care by House Of Maithili artisans.</p>@if($product->is_made_to_order)<span>Made to order · {{ $product->lead_time_days ?: 15 }} working days</span>@endif</div>
            <div class="hom-story-steps"><h2>From our hands to your home</h2><ol><li><i>01</i><span>Choose your piece</span></li><li><i>02</i><span>Artisans prepare it</span></li><li><i>03</i><span>Carefully packed</span></li><li><i>04</i><span>Delivered to you</span></li></ol></div>
            <div class="hom-story-care"><h2>Care &amp; details</h2><p>Handcrafted in Bihar. Small variations in handwork are part of the character of each piece.</p><a href="mailto:info@houseofmaithili.com?subject={{ rawurlencode('Care and sizing question: '.$product->name) }}">Ask about sizing or care <span aria-hidden="true">→</span></a></div>
        </section>
    </div>

    <section class="hom-related-section" aria-labelledby="hom-related-title"><div class="container">
            <div class="hom-related-heading"><div><p class="hom-detail-eyebrow">THE HOUSE OF MAITHILI EDIT</p><h2 id="hom-related-title">You may also like</h2></div><a href="{{ route('shop.index', ['category' => $product->category->slug]) }}">View collection <span aria-hidden="true">→</span></a></div>
            <div class="hom-related-grid">
                @foreach($relatedProducts as $related)
                    <a class="hom-related-card" href="{{ route('shop.products.show', $related->slug) }}">
                        <div class="hom-related-image">@if($related->thumbnail && is_file(public_path('uploads/products/'.$related->thumbnail)))<img src="{{ asset('uploads/products/'.$related->thumbnail) }}" alt="{{ $related->name }}">@else<div class="hom-product-image-empty">House Of Maithili</div>@endif@if($related->is_made_to_order)<span>Made to order</span>@endif</div>
                        <div class="hom-related-info"><h3>{{ $related->name }}</h3><p>₹{{ number_format((float)($related->sale_price ?: $related->price), 2) }}</p>@if($related->variants_count)<small>{{ $related->variants_count }} size / colour options</small>@endif</div>
                    </a>
                @endforeach
            </div>
            @if($relatedProducts->isEmpty())<p class="hom-related-empty">More handcrafted pieces are on their way. Please check back soon.</p>@endif
        </div></section>
</main>
<script>
document.querySelectorAll('.hom-thumb').forEach(button => button.addEventListener('click', () => {
    const mainImage = document.getElementById('hom-main-image');
    if (mainImage) mainImage.src = button.dataset.image;
    document.querySelectorAll('.hom-thumb').forEach(item => item.classList.toggle('is-selected', item === button));
}));
document.querySelectorAll('.hom-variant-option').forEach(button => button.addEventListener('click', () => {
    document.querySelectorAll('.hom-variant-option').forEach(item => { item.classList.toggle('is-selected', item === button); item.setAttribute('aria-pressed', item === button ? 'true' : 'false'); });
    const selectedPrice = document.getElementById('selected-price');
    selectedPrice.textContent = '₹' + Number(button.dataset.price).toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2});
    const originalPrice = document.getElementById('selected-original-price');
    if (originalPrice) {
        originalPrice.textContent = '₹' + Number(button.dataset.original).toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2});
        originalPrice.hidden = Number(button.dataset.price) >= Number(button.dataset.original);
    }
    const stock = Number(button.dataset.stock);
    document.getElementById('variant-availability').textContent = stock > 0 ? stock + ' available to ship' : @json($product->is_made_to_order ? 'Made to order · crafted in '.($product->lead_time_days ?: 15).' working days' : 'Currently unavailable');
    document.getElementById('selected-variant-id').value = button.dataset.id;
    document.getElementById('add-to-cart-button').disabled = false;
    document.getElementById('buy-now-button').disabled = false;
    updateWhatsAppLink(button.dataset.label);
}));
const quantityInput = document.getElementById('product-quantity');
function updateWhatsAppLink(optionLabel = document.querySelector('.hom-variant-option.is-selected')?.dataset.label || '') {
    const message = 'Namaste House Of Maithili, please help me order ' + @json($product->name) + (optionLabel ? ' in ' + optionLabel : '') + ', quantity ' + quantityInput.value + '.';
    document.getElementById('product-whatsapp-link').href = 'https://wa.me/{{ preg_replace('/\D+/', '', (string) config('services.house_of_maithili_whatsapp')) }}?text=' + encodeURIComponent(message);
}
document.getElementById('quantity-minus').addEventListener('click', () => quantityInput.value = Math.max(1, Number(quantityInput.value || 1) - 1));
document.getElementById('quantity-plus').addEventListener('click', () => quantityInput.value = Math.min(20, Number(quantityInput.value || 1) + 1));
quantityInput.addEventListener('change', () => { quantityInput.value = Math.min(20, Math.max(1, Number(quantityInput.value || 1))); updateWhatsAppLink(); });
document.getElementById('quantity-minus').addEventListener('click', () => updateWhatsAppLink());
document.getElementById('quantity-plus').addEventListener('click', () => updateWhatsAppLink());
document.getElementById('product-purchase-form').addEventListener('submit', event => {
    if (document.querySelectorAll('.hom-variant-option').length && !document.getElementById('selected-variant-id').value) {
        event.preventDefault();
        document.getElementById('variant-availability').textContent = 'Please choose a size or colour first.';
    }
});
const sizeGuide = document.getElementById('hom-size-guide');
document.getElementById('size-guide-open')?.addEventListener('click', () => sizeGuide.showModal());
document.getElementById('size-guide-close')?.addEventListener('click', () => sizeGuide.close());
</script>
@endsection
