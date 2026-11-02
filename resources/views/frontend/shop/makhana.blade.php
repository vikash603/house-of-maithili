@extends('frontend.layout.app')

@section('content')
<main class="main maithili-shop-results maithili-makhana-listing">
    <section class="maithili-shop-results-section">
        <div class="container">
            <p class="maithili-section-eyebrow">HOUSE OF MAITHILI · BIHAR’S HANDPICKED GOODNESS</p>
            <h1>Premium Makhana Collection</h1>
            <p class="maithili-shop-results-intro">Discover makhana from Bihar, selected with care and brought to you by House Of Maithili.</p>

            @if(session('cart_success'))
                <p class="maithili-bestseller-notice" role="status">{{ session('cart_success') }} <a href="{{ route('cart.index') }}">View your bag</a></p>
            @endif

            <div class="maithili-shop-results-meta" aria-live="polite">
                <span>{{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }} available</span>
            </div>

            @if($products->isEmpty())
                <div class="maithili-shop-results-empty">
                    <span class="far fa-leaf" aria-hidden="true"></span>
                    <h2>Makhana products are coming soon</h2>
                    <p>We’re preparing this collection. Please check back soon or explore the rest of our handcrafted edit.</p>
                    <a href="{{ route('shop.index') }}">Explore all pieces</a>
                </div>
            @else
                <div class="maithili-product-grid">
                    @foreach($products as $product)
                        @php
                            $galleryImage = $product->images->first(fn ($image) => is_file(public_path('uploads/products/'.$image->image)));
                            $productImage = $product->thumbnail && is_file(public_path('uploads/products/'.$product->thumbnail))
                                ? asset('uploads/products/'.$product->thumbnail)
                                : ($galleryImage ? asset('uploads/products/'.$galleryImage->image) : null);
                            $currentPrice = (float) ($product->sale_price ?: $product->price);
                            $hasDiscount = $product->sale_price && (float) $product->sale_price < (float) $product->price;
                            $inStock = $product->is_made_to_order || ($product->variants_count
                                ? $product->variants->contains(fn ($variant) => $variant->stock > 0)
                                : $product->stock > 0);
                        @endphp
                        <article class="maithili-product-card">
                            <a class="maithili-product-card-main" href="{{ route('shop.products.show', $product->slug) }}">
                                <div class="maithili-product-image">
                                    @if($productImage)
                                        <img src="{{ $productImage }}" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <div class="maithili-product-image-pending" role="img" aria-label="Product image pending"><span>Product image pending</span></div>
                                    @endif
                                </div>
                                <div class="maithili-product-info">
                                    @if($product->category)<span class="maithili-product-category">{{ $product->category->name }}</span>@endif
                                    <h2>{{ $product->name }}</h2>
                                    <p class="maithili-product-price">₹{{ number_format($currentPrice, 2) }} @if($hasDiscount)<del>₹{{ number_format((float) $product->price, 2) }}</del>@endif</p>
                                    <span class="maithili-makhana-availability {{ $inStock ? 'is-available' : 'is-unavailable' }}">{{ $product->is_made_to_order ? 'Made to order' : ($inStock ? 'In stock' : 'Out of stock') }}</span>
                                </div>
                            </a>
                            @if($inStock && !$product->variants_count)
                                <form class="maithili-makhana-cart-form" method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit">Add to bag <span aria-hidden="true">→</span></button>
                                </form>
                            @elseif($inStock)
                                <a class="maithili-product-view" href="{{ route('shop.products.show', $product->slug) }}">Choose options <span aria-hidden="true">→</span></a>
                            @else
                                <span class="maithili-product-view is-disabled" aria-disabled="true">Currently unavailable</span>
                            @endif
                        </article>
                    @endforeach
                </div>
                @if($products->hasPages())
                    <nav class="maithili-shop-pagination" aria-label="Makhana product pages">{{ $products->onEachSide(1)->links() }}</nav>
                @endif
            @endif
        </div>
    </section>
</main>
@endsection
