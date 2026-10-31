
@extends('frontend.layout.app')
@section('content')

    <main class="main">

        <!-- hero slider -->
        <section class="hero-section hs-1 maithili-hero {{ isset($banners) && $banners->where('is_active', true)->count() > 1 ? 'has-multiple-banners' : '' }}" id="hero" aria-label="House Of Maithili introduction">
            @php
                $activeBanners = isset($banners) ? $banners->where('is_active', true) : collect();
            @endphp
            @if ($activeBanners->isNotEmpty())
                <div class="hero-slider owl-carousel owl-theme maithili-hero-slider">
                    @foreach ($activeBanners as $banner)
                        <div class="hero-single maithili-hero-slide">
                            <div class="maithili-hero-photo">
                                @if ($banner->link_url)
                                    <a href="{{ str_starts_with($banner->link_url, '/') ? url(ltrim($banner->link_url, '/')) : $banner->link_url }}" aria-label="{{ $banner->alt_text ?: 'Open banner destination' }}">
                                        <img src="{{ asset($banner->image) }}" alt="{{ $banner->alt_text ?? '' }}">
                                    </a>
                                @else
                                    <img src="{{ asset($banner->image) }}" alt="{{ $banner->alt_text ?? '' }}">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif (! isset($banners) || $banners->isEmpty())
                <div class="hero-slider owl-carousel owl-theme maithili-hero-slider">
                    <div class="hero-single maithili-hero-slide">
                        <div class="maithili-hero-photo" aria-hidden="true">
                            <img src="{{ asset('frontend/images/Serene Saree Portrait in Heritage Architecture.png') }}" alt="">
                        </div>
                    </div>
                </div>
            @endif
        </section>
        <!-- hero slider end -->

        <!-- Home page highlights are managed from the admin panel -->
        @if($homeHighlights->isNotEmpty())
            <section class="maithili-highlights" aria-label="House Of Maithili values and services">
                <div class="container"><ul class="maithili-highlights-list">
                    @foreach($homeHighlights as $highlight)
                        <li class="maithili-highlight-item">
                            <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                @switch($highlight->icon)
                                    @case('community')<circle cx="12" cy="9" r="3"/><circle cx="21" cy="10" r="2.5"/><path d="M5 25v-3a7 7 0 0 1 14 0v3M18 18a5 5 0 0 1 9 3v4h-5"/><path class="accent" d="M9 28h15"/>@break
                                    @case('leaf')<path d="M16 27V15M16 20c-6 0-9-4-9-10 6 0 9 4 9 10ZM16 17c0-6 4-10 10-10 0 6-4 10-10 10Z"/><path class="accent" d="M11 27h10"/>@break
                                    @case('shipping')<path d="M4 9h15v13H4zM19 13h5l4 5v4h-9zM9 26a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM23 26a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/><path class="accent" d="M7 13h8M21 16h3"/>@break
                                    @default<path d="M6 23 23 6l3 3L9 26H6zM19 10l3 3M15 14l3 3M11 18l3 3"/><path class="accent" d="m23 6 2-2 3 3-2 2"/>
                                @endswitch
                            </svg>
                            <span>{{ $highlight->title }}</span>
                        </li>
                    @endforeach
                </ul></div>
            </section>
        @endif

        <!-- Shop by Category: category images come from approved active category records when available -->
        <section class="maithili-shop-by-category" aria-labelledby="maithili-shop-category-title">
            <div class="container">
                <div class="maithili-shop-category-heading">
                    <h2 id="maithili-shop-category-title">Shop by Category</h2>
                    <div class="maithili-shop-category-controls" aria-label="Category slider controls">
                        <button type="button" class="maithili-category-prev" aria-label="Previous categories">‹</button>
                        <button type="button" class="maithili-category-next" aria-label="Next categories">›</button>
                    </div>
                </div>
                <div class="maithili-shop-category-list" tabindex="0" aria-label="Fashion categories; use the arrows or swipe to browse">
                    @forelse($shopCategories as $category)
                        @php
                            $categoryImagePath = $category->image
                                ? public_path('uploads/category/'.$category->image)
                                : null;
                        @endphp
                        <a class="maithili-shop-category-card" href="{{ route('shop.index', ['category' => $category->slug ?: \Illuminate\Support\Str::slug($category->name)]) }}">
                            @if($categoryImagePath && is_file($categoryImagePath))
                                <img class="maithili-shop-category-image" src="{{ asset('uploads/category/'.$category->image) }}" alt="{{ $category->name }} category">
                            @else
                                <span class="maithili-shop-category-placeholder" role="img" aria-label="Category image pending for {{ $category->name }}"><span>{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($category->name, 0, 1)) }}</span></span>
                                <span class="maithili-category-photo-note">Photo pending</span>
                            @endif
                            <span class="maithili-shop-category-name">{{ $category->name }}</span>
                        </a>
                    @empty
                        <p class="maithili-shop-category-empty">Categories will be added soon.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Institutional client logos -->
        <section class="maithili-institutional-clients" aria-labelledby="maithili-clients-title">
            <div class="container maithili-clients-inner">
                <header class="maithili-clients-heading">
                    <h2 id="maithili-clients-title">Our Esteemed Institutional Clients</h2>
                    <p class="maithili-clients-subtitle">Proud to have created handcrafted products for leading institutions and government organizations.</p>
                </header>
                @php
                    $institutionalLogos = [
                        ['name' => 'India Post', 'file' => 'India_Post_Logo_potools.webp'],
                        ['name' => 'State Bank of India (SBI)', 'file' => 'images-sbi.png'],
                        ['name' => 'HP Gas', 'file' => 'hp-gas.png'],
                        ['name' => 'District Administration Kishanganj, Government of Bihar', 'file' => 'image_c34d60dc (1).jpg'],
                    ];
                    $hasInstitutionalLogos = false;
                    foreach ($institutionalLogos as $logo) {
                        if (is_file(public_path('frontend/images/' . $logo['file']))) {
                            $hasInstitutionalLogos = true;
                            break;
                        }
                    }
                @endphp
                @if ($hasInstitutionalLogos)
                    <ul class="maithili-client-logo-list" aria-label="Institutional client logos">
                        @foreach ($institutionalLogos as $logo)
                            @if (is_file(public_path('frontend/images/' . $logo['file'])))
                                <li class="maithili-client-logo-item">
                                    <img src="{{ asset('frontend/images/' . $logo['file']) }}" alt="{{ $logo['name'] }}" loading="lazy">
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>

        <!-- Artisan and impact stories -->
        @if(isset($stories) && $stories->isNotEmpty())
        <section class="maithili-stories" aria-labelledby="maithili-stories-title">
            <a class="maithili-watch-all-overlay" href="https://www.youtube.com/@HouseofMaithili" target="_blank" rel="noopener noreferrer" aria-label="Watch all videos on the House Of Maithili YouTube channel"></a>
            <div class="container">
                <div class="maithili-stories-layout">
                    <div class="maithili-stories-intro">
                        <span class="maithili-stories-eyebrow">OUR STORY IN MOTION</span>
                        <h2 id="maithili-stories-title">Stories of Artisans, Art &amp; Impact</h2>
                        <p>Watch real stories from our artisans, collections, events and the journey of House Of Maithili.</p>
                        <a class="maithili-stories-button" href="https://www.youtube.com/@HouseofMaithili" target="_blank" rel="noopener noreferrer">WATCH ALL VIDEOS <span aria-hidden="true">→</span></a>
                    </div>
                    <div class="maithili-story-list" id="maithili-story-list" tabindex="0" aria-label="Stories and films; scroll horizontally to see more">
                        @foreach($stories as $story)
                            <article class="maithili-story-card">
                                <button class="maithili-story-thumb" type="button"
                                    data-story-type="{{ $story->video_type }}"
                                    data-story-url="{{ $story->video_type === 'youtube' ? $story->youtubeEmbedUrl() : asset($story->video_file) }}"
                                    data-story-title="{{ $story->title }}"
                                    aria-label="Play {{ $story->title }}">
                                    @if($story->thumbnailUrl())<img src="{{ $story->thumbnailUrl() }}" alt="" loading="lazy">@endif
                                    <span class="maithili-story-play" aria-hidden="true">▶</span>
                                </button>
                                <h3>{{ $story->title }}</h3>
                                @if($story->description)<p class="maithili-story-description">{{ $story->description }}</p>@endif
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
            <dialog class="maithili-story-dialog" id="maithili-story-dialog" aria-label="Story video player">
                <div class="maithili-story-dialog-header"><h2 id="maithili-story-dialog-title"></h2><button type="button" class="maithili-story-dialog-close" aria-label="Close video">&times;</button></div>
                <div class="maithili-story-player">
                    <iframe title="House Of Maithili story video" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen referrerpolicy="strict-origin-when-cross-origin" hidden></iframe>
                    <video controls playsinline hidden></video>
                </div>
            </dialog>
        </section>
        <script>
        (() => {
            const dialog = document.getElementById('maithili-story-dialog');
            const iframe = dialog?.querySelector('iframe');
            const video = dialog?.querySelector('video');
            const title = document.getElementById('maithili-story-dialog-title');
            if (!dialog || !iframe || !video) return;

            const stopVideo = () => {
                iframe.src = 'about:blank';
                iframe.hidden = true;
                video.pause();
                video.removeAttribute('src');
                video.load();
                video.hidden = true;
            };
            document.querySelectorAll('[data-story-type][data-story-url]').forEach((button) => {
                button.addEventListener('click', () => {
                    stopVideo();
                    title.textContent = button.dataset.storyTitle || 'House Of Maithili story';
                    if (button.dataset.storyType === 'youtube') {
                        iframe.src = button.dataset.storyUrl;
                        iframe.hidden = false;
                    } else {
                        video.src = button.dataset.storyUrl;
                        video.hidden = false;
                        video.play().catch(() => {});
                    }
                    dialog.showModal();
                });
            });
            dialog.querySelector('.maithili-story-dialog-close')?.addEventListener('click', () => dialog.close());
            dialog.addEventListener('click', (event) => { if (event.target === dialog) dialog.close(); });
            dialog.addEventListener('close', stopVideo);
        })();
        </script>
        @endif

                <!-- House Of Maithili bestsellers -->
        <section class="maithili-bestsellers py-80" id="maithili-bestsellers" aria-labelledby="maithili-bestsellers-title">
            <div class="container">
                <div class="maithili-section-heading">
                    <span class="maithili-section-eyebrow">THE HOUSE OF MAITHILI EDIT</span>
                    <h2 id="maithili-bestsellers-title">Bestsellers</h2>
                    <p>Discover handcrafted favourites, thoughtfully made by our artisan community.</p>
                </div>
                @if(isset($bestsellers) && $bestsellers->isNotEmpty())
                    @if(session('cart_success'))<p class="maithili-bestseller-notice" role="status">{{ session('cart_success') }} <a href="{{ route('cart.index') }}">View your bag</a></p>@endif
                    <div class="maithili-product-grid">
                        @foreach($bestsellers as $product)
                            @php
                                $bestsellerImage = $product->thumbnail && is_file(public_path('uploads/products/'.$product->thumbnail))
                                    ? asset('uploads/products/'.$product->thumbnail)
                                    : ($product->images->first() && is_file(public_path('uploads/products/'.$product->images->first()->image))
                                        ? asset('uploads/products/'.$product->images->first()->image)
                                        : null);
                                $bestsellerPrice = (float) ($product->sale_price ?: $product->price);
                            @endphp
                            <article class="maithili-product-card">
                                <div class="maithili-product-image">
                                    <a class="maithili-product-image-link" href="{{ route('shop.products.show', $product->slug) }}" aria-label="View {{ $product->name }}">
                                    @if($bestsellerImage)
                                        <img src="{{ $bestsellerImage }}" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <div class="maithili-product-image-pending" role="img" aria-label="Product image pending"><span>Product image pending</span></div>
                                    @endif
                                    </a>
                                    <span class="maithili-product-badge">{{ $product->is_made_to_order ? 'Made to order' : 'Handcrafted' }}</span>
                                </div>
                                <div class="maithili-product-info">
                                    <p class="maithili-product-category">{{ $product->category->name }}</p>
                                    <h3><a href="{{ route('shop.products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                    <div class="maithili-product-prices">
                                        <strong data-current-price>₹{{ number_format($bestsellerPrice, 2) }}</strong>
                                        @if($product->sale_price)<del data-original-price>₹{{ number_format((float) $product->price, 2) }}</del>@else<del data-original-price hidden></del>@endif
                                    </div>
                                    <form class="maithili-bestseller-form" method="POST" action="{{ route('cart.add') }}" data-bestseller-form>
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        @if($product->variants->isNotEmpty())
                                            <label class="visually-hidden" for="bestseller-variant-{{ $product->id }}">Choose a size or colour for {{ $product->name }}</label>
                                            <select class="maithili-variant-select" id="bestseller-variant-{{ $product->id }}" name="variant_id" required data-bestseller-variant>
                                                <option value="">Choose size / colour</option>
                                                @foreach($product->variants as $variant)
                                                    @php($variantLabel = collect([$variant->size, $variant->color])->filter()->join(' · '))
                                                    @php($variantPrice = (float) ($variant->sale_price ?: $variant->price ?: $product->sale_price ?: $product->price))
                                                    @php($variantOriginalPrice = (float) ($variant->price ?: $product->price))
                                                    <option value="{{ $variant->id }}" data-price="{{ $variantPrice }}" data-original="{{ $variantOriginalPrice }}" @disabled(!$product->is_made_to_order && $variant->stock < 1)>
                                                        {{ $variantLabel ?: 'Option '.$loop->iteration }}{{ !$product->is_made_to_order && $variant->stock < 1 ? ' · Out of stock' : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <div class="maithili-product-actions">
                                            <button type="submit" class="maithili-add-to-bag" @disabled($product->variants->isNotEmpty())>Add to Bag</button>
                                            <button type="submit" class="maithili-buy-now" formaction="{{ route('cart.buy-now') }}" @disabled($product->variants->isNotEmpty())>Buy Now</button>
                                        </div>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="maithili-data-pending" role="status">No active products are available yet. Add an active product with ready stock or enable made-to-order in the catalogue to display it here.</div>
                @endif
            </div>
        </section>
        <!-- House Of Maithili bestsellers end -->

        <script>
        document.querySelectorAll('[data-bestseller-variant]').forEach((select) => {
            const form = select.closest('[data-bestseller-form]');
            const card = select.closest('.maithili-product-card');
            const buttons = form.querySelectorAll('button[type="submit"]');
            const price = card.querySelector('[data-current-price]');
            const original = card.querySelector('[data-original-price]');
            const updateSelection = () => {
                const option = select.selectedOptions[0];
                const selected = Boolean(select.value) && !option.disabled;
                buttons.forEach((button) => button.disabled = !selected);
                if (!selected) return;
                const amount = Number(option.dataset.price);
                const regular = Number(option.dataset.original);
                price.textContent = '₹' + amount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                original.textContent = '₹' + regular.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                original.hidden = amount >= regular;
            };
            select.addEventListener('change', updateSelection);
            updateSelection();
        });
        </script>

                <!-- House Of Maithili impact -->
        <section class="maithili-impact" id="maithili-impact" aria-labelledby="maithili-impact-title">
            <div class="container">
                <div class="maithili-impact-accessible-content">
                    <h2 id="maithili-impact-title">More Than Fashion, A Bigger Purpose</h2>
                    <p>Every purchase supports rural women artisans of Purnea, helping them build sustainable livelihoods and keep traditional art forms alive.</p>
                    <ul>
                        <li>65+ women artisans engaged</li>
                        <li>Traditional art forms revived</li>
                        <li>Sustainable livelihoods</li>
                        <li>Stronger rural communities</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- House Of Maithili impact end -->

        <!-- Publication logos supplied for the approved media strip -->
        <section class="maithili-media-mentions" id="maithili-as-seen-in" aria-labelledby="maithili-media-title">
            <div class="container">
                <div class="maithili-section-heading">
                    <span class="maithili-section-eyebrow">PRESS &amp; FEATURES</span>
                    <h2 id="maithili-media-title">As Seen In</h2>
                </div>
                <ul class="maithili-media-list" aria-label="Featured publications">
                    <li><img src="{{ asset('frontend/images/mid-day-squarelogo_d.webp') }}" alt="Mid-Day" loading="lazy"></li>
                    <li><img src="{{ asset('frontend/images/Aaj_tak_logo.png') }}" alt="Aaj Tak" loading="lazy"></li>
                    <li><img src="{{ asset('frontend/images/Dd-news_logo.png') }}" alt="DD News" loading="lazy"></li>
                </ul>
            </div>
        </section>

        <!-- Approved customer testimonials managed in the admin panel -->
        <section class="maithili-testimonials" id="maithili-testimonials" aria-labelledby="maithili-testimonials-title">
            <div class="container">
                <div class="maithili-testimonials-heading">
                    <div class="maithili-section-heading">
                        <span class="maithili-section-eyebrow">CUSTOMER VOICES</span>
                        <h2 id="maithili-testimonials-title">Loved by Our Customers</h2>
                    </div>
                    @if($testimonials->count() > 3)
                        <div class="maithili-testimonial-controls" aria-label="Testimonial controls">
                            <button type="button" data-testimonial-direction="-1" aria-label="Previous testimonials">‹</button>
                            <button type="button" data-testimonial-direction="1" aria-label="Next testimonials">›</button>
                        </div>
                    @endif
                </div>
                <div class="maithili-testimonial-track" id="maithili-testimonial-track" aria-live="polite">
                    @forelse($testimonials as $testimonial)
                        <article class="maithili-testimonial-card">
                            <div class="maithili-testimonial-person">
                                @if($testimonial->photo)
                                    <img class="maithili-testimonial-avatar" src="{{ asset($testimonial->photo) }}" alt="{{ $testimonial->customer_name }}" loading="lazy">
                                @else
                                    <span class="maithili-testimonial-avatar maithili-testimonial-initial" aria-hidden="true">{{ mb_strtoupper(mb_substr($testimonial->customer_name, 0, 1)) }}</span>
                                @endif
                                <div class="maithili-testimonial-copy">
                                    <div class="maithili-empty-stars" aria-label="{{ (int) $testimonial->rating }} out of 5 stars">
                                        @for($star = 1; $star <= 5; $star++){{ $star <= (int) $testimonial->rating ? '★' : '☆' }}@endfor
                                    </div>
                                    @if($testimonial->title)<h3>{{ $testimonial->title }}</h3>@endif
                                    <blockquote>{{ $testimonial->quote }}</blockquote>
                                    <span class="maithili-testimonial-name">{{ $testimonial->customer_name }}</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="maithili-testimonial-empty">Customer stories will appear here as reviews are approved.</p>
                    @endforelse
                </div>
            </div>
        </section>
        <script>
            (() => {
                const track = document.getElementById('maithili-testimonial-track');
                if (!track) return;
                document.querySelectorAll('[data-testimonial-direction]').forEach((button) => {
                    button.addEventListener('click', () => {
                        const card = track.querySelector('.maithili-testimonial-card');
                        const gap = 18;
                        track.scrollBy({ left: (card ? card.getBoundingClientRect().width + gap : track.clientWidth) * Number(button.dataset.testimonialDirection), behavior: 'smooth' });
                    });
                });
            })();
        </script>





        <!-- House Of Maithili newsletter signup -->
        <section class="maithili-newsletter" id="maithili-newsletter" aria-labelledby="maithili-newsletter-title">
            <div class="container">
                <div class="maithili-newsletter-panel">
                    <span class="maithili-section-eyebrow">LETTERS FROM THE HOUSE</span>
                    <h2 id="maithili-newsletter-title">Stay in the loop</h2>
                    <p>Occasional notes on new collections, craft and life at House Of Maithili.</p>
                    <form class="maithili-newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <label class="visually-hidden" for="maithili-newsletter-email">Email address</label>
                        <input id="maithili-newsletter-email" name="email" type="email" value="{{ old('email') }}" placeholder="Your email address" autocomplete="email" required aria-describedby="maithili-newsletter-status" @if($errors->has('email')) aria-invalid="true" @endif>
                        <button type="submit">Subscribe</button>
                    </form>
                    <p class="maithili-newsletter-status @if(session('newsletter_error') || $errors->has('email')) maithili-newsletter-error @endif" id="maithili-newsletter-status" @if(session('newsletter_error') || $errors->has('email')) role="alert" @else role="status" @endif>
                        {{ session('newsletter_success') ?? session('newsletter_error') ?? $errors->first('email') }}
                    </p>
                </div>
            </div>
        </section>




    </main>

@endsection
