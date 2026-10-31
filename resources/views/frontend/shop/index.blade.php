@extends('frontend.layout.app')

@section('content')
<main class="main maithili-shop-results">
    <section class="maithili-shop-results-section">
        <div class="container">
            <p class="maithili-section-eyebrow">HOUSE OF MAITHILI · THE HANDCRAFTED EDIT</p>
            <h1>{{ $category?->name ?? ($query !== '' ? 'Search results' : 'Shop all') }}</h1>
            @if($query !== '')
                <p class="maithili-shop-results-intro">Showing available pieces for <strong>“{{ $query }}”</strong></p>
            @elseif($category)
                <p class="maithili-shop-results-intro">Discover handcrafted pieces from our {{ $category->name }} collection.</p>
            @else
                <p class="maithili-shop-results-intro">Explore thoughtfully made fashion and home pieces from our artisan community.</p>
            @endif

            <form class="maithili-shop-filter" method="GET" action="{{ route('shop.index') }}" role="search">
                <label class="maithili-shop-filter-search">
                    <span class="visually-hidden">Search products</span>
                    <i class="far fa-search" aria-hidden="true"></i>
                    <input type="search" name="q" value="{{ $query }}" placeholder="Search products, styles or crafts...">
                </label>
                <label>
                    <span class="visually-hidden">Filter by category</span>
                    <select name="category" aria-label="Filter by category">
                        <option value="">All categories</option>
                        @foreach($categories as $option)
                            <option value="{{ $option->slug }}" @selected($categorySlug === $option->slug)>{{ $option->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <span class="visually-hidden">Sort products</span>
                    <select name="sort" aria-label="Sort products">
                        <option value="relevance" @selected($sort === 'relevance')>Recommended</option>
                        <option value="newest" @selected($sort === 'newest')>Newest</option>
                        <option value="price_asc" @selected($sort === 'price_asc')>Price: low to high</option>
                        <option value="price_desc" @selected($sort === 'price_desc')>Price: high to low</option>
                    </select>
                </label>
                <button type="submit">Apply</button>
            </form>

            <div class="maithili-shop-results-meta" aria-live="polite">
                <span>{{ $products->total() }} {{ \Illuminate\Support\Str::plural('piece', $products->total()) }} available</span>
                @if($query !== '' || $categorySlug !== '')
                    <a href="{{ route('shop.index') }}">Clear filters</a>
                @endif
            </div>

            @if($products->isEmpty())
                <div class="maithili-shop-results-empty">
                    <span class="far fa-search" aria-hidden="true"></span>
                    <h2>No pieces found</h2>
                    <p>Try a broader search or browse all active categories.</p>
                    <a href="{{ route('shop.index') }}">Explore all pieces</a>
                </div>
            @else
                <div class="maithili-product-grid">
                    @foreach($products as $product)
                        <article class="maithili-product-card">
                            <a class="maithili-product-card-main" href="{{ route('shop.products.show', $product->slug) }}">
                                <div class="maithili-product-image">
                                    @if($product->thumbnail && is_file(public_path('uploads/products/'.$product->thumbnail)))
                                        <img src="{{ asset('uploads/products/'.$product->thumbnail) }}" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <div class="maithili-product-image-pending" role="img" aria-label="Product image pending"><span>Product image pending</span></div>
                                    @endif
                                </div>
                                <div class="maithili-product-info">
                                    @if($product->category)<span class="maithili-product-category">{{ $product->category->name }}</span>@endif
                                    <h2>{{ $product->name }}</h2>
                                    <p class="maithili-product-price">{{ $product->is_made_to_order ? 'Made to order · ' : '' }}₹{{ number_format((float) ($product->sale_price ?: $product->price), 2) }}</p>
                                    @if($product->variants_count)<span class="maithili-product-options">{{ $product->variants_count }} size / colour options</span>@endif
                                </div>
                            </a>
                            <a class="maithili-product-view" href="{{ route('shop.products.show', $product->slug) }}">View details <span aria-hidden="true">→</span></a>
                        </article>
                    @endforeach
                </div>
                @if($products->hasPages())
                    <nav class="maithili-shop-pagination" aria-label="Product result pages">{{ $products->onEachSide(1)->links() }}</nav>
                @endif
            @endif
        </div>
    </section>
</main>
@endsection
