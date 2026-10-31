<!DOCTYPE html><html lang="en"><head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="House Of Maithili — Indian fashion with a contemporary point of view.">
    <meta name="keywords" content="House Of Maithili, Indian fashion, women’s clothing">

    <!-- title -->
    <title>House Of Maithili | Indian Fashion</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('/')}}/frontend/favicon.png">

    <!-- css -->
    <link rel="stylesheet" href="{{url('/')}}/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/')}}/frontend/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="{{url('/')}}/frontend/css/animate.min.css">
    <link rel="stylesheet" href="{{url('/')}}/frontend/css/magnific-popup.min.css">
    <link rel="stylesheet" href="{{url('/')}}/frontend/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{url('/')}}/frontend/css/jquery-ui.min.css">
    <link rel="stylesheet" href="{{url('/')}}/frontend/css/nice-select.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}?v={{ filemtime(public_path('frontend/css/style.css')) }}">
    @yield('page-css')

</head>

<body>

    <!-- preloader -->
    <div class="preloader">
        <div class="loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- preloader end -->


    <!-- header area -->
    <header class="header">

        <!-- header top -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrapper">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-5">
                            <div class="header-top-left">
                                <ul class="header-top-list">
                                    <li><a href="#"><i class="far fa-envelopes"></i>
                                            info@houseofmaithili.com</a></li>
                                    <li><a href="tel:+918226803011"><i class="far fa-headset"></i> +91 82268 03011</a>
                                    </li>
                                    <li class="help"><a href="#"><i class="far fa-comment-question"></i> Need Help?</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-7">
                            <div class="header-top-right">
                                <ul class="header-top-list">
                                    <li><a href="{{ auth()->check() ? route('account.orders.index') : route('login') }}"><i class="far fa-sign-in"></i> {{ auth()->check() ? 'My Account' : 'Login' }}</a></li>
                                    
                                    
                                    <li class="social">
                                        <div class="header-top-social">
                                            <span>Follow Us: </span>
                                            <a href="#"><i class="fab fa-facebook"></i></a>
                                            <a href="#"><i class="fab fa-x-twitter"></i></a>
                                            <a href="#"><i class="fab fa-instagram"></i></a>
                                            <a href="#"><i class="fab fa-linkedin"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header top end -->

        <!-- navbar -->
        <div class="main-navigation">
            <nav class="navbar navbar-expand-xl" aria-label="Main navigation">
                <div class="container position-relative">
                    <a class="navbar-brand maithili-brand" href="{{ url('/') }}" aria-label="House Of Maithili home">
                        <img src="{{ url('/') }}/frontend/images/house-of-maithili.png" alt="House Of Maithili" width="150" height="auto">
                    </a>
                    <div class="mobile-menu-right">
                        <div class="mobile-menu-btn">
                            <a href="#" class="nav-right-link search-box-outer" aria-label="Search"><i class="far fa-search"></i></a>
                            <a href="{{ auth()->check() ? route('account.orders.index') : route('login') }}" class="nav-right-link" aria-label="My account"><i class="far fa-user"></i></a>
                            <a href="#" class="nav-right-link" aria-label="Wishlist"><i class="far fa-heart"></i></a>
                            <a href="{{ route('cart.index') }}" class="nav-right-link maithili-bag-link" aria-label="Shopping bag"><i class="far fa-shopping-bag"></i>@if(collect(session('hom_cart', []))->sum())<span>{{ collect(session('hom_cart', []))->sum() }}</span>@endif</a>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span></span><span></span><span></span>
                        </button>
                    </div>
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <a href="{{ url('/') }}" class="offcanvas-brand" id="offcanvasNavbarLabel">
                                <img src="{{ url('/') }}/frontend/images/house-of-maithili.png" alt="House Of Maithili" width="150" height="auto">
                            </a>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close navigation"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav flex-grow-1 maithili-nav-links">
                                <li class="nav-item"><a class="nav-link" href="{{ route('shop.index', ['sort' => 'newest']) }}">New Arrivals</a></li>
                                <li class="nav-item maithili-shop-menu">
                                    <a class="nav-link" href="{{ route('shop.index') }}" aria-haspopup="true">Shop <span aria-hidden="true">⌄</span></a>
                                    <div class="maithili-shop-dropdown">
                                        <a class="maithili-shop-dropdown-all" href="{{ route('shop.index') }}">Shop all pieces <span aria-hidden="true">→</span></a>
                                        @forelse($navCategories as $navCategory)
                                            <a href="{{ route('shop.index', ['category' => $navCategory->slug]) }}">{{ $navCategory->name }}</a>
                                            @foreach($navCategory->subcategories as $navSubcategory)
                                                <a class="maithili-shop-dropdown-subcategory" href="{{ route('shop.index', ['category' => $navCategory->slug, 'subcategory' => $navSubcategory->slug]) }}">{{ $navSubcategory->name }}</a>
                                            @endforeach
                                        @empty
                                            <span class="maithili-shop-dropdown-empty">Categories coming soon</span>
                                        @endforelse
                                    </div>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/#maithili-stories') }}">Our Story</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/#maithili-impact') }}">Impact</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/#maithili-contact') }}">Corporate Orders</a></li>
                            </ul>
                            <a href="#" class="maithili-search-trigger search-box-outer" role="button" aria-label="Open search">
                                <i class="far fa-search" aria-hidden="true"></i>
                                <span>Search for handcrafted products...</span>
                            </a>
                            <div class="nav-right maithili-nav-right">
                                <ul class="nav-right-list">
                                    <li><a href="#" class="list-link search-box-outer" aria-label="Search"><i class="far fa-search"></i></a></li>
                                    <li><a href="{{ auth()->check() ? route('account.orders.index') : route('login') }}" class="list-link" aria-label="My account"><i class="far fa-user"></i></a></li>
                                    <li><a href="{{ route('cart.index') }}" class="list-link maithili-bag-link" aria-label="Shopping bag"><i class="far fa-shopping-bag"></i>@if(collect(session('hom_cart', []))->sum())<span>{{ collect(session('hom_cart', []))->sum() }}</span>@endif</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <nav class="maithili-mobile-nav" aria-label="Shop categories">
                <div class="container">
                    <ul>
                        <li><a href="{{ route('shop.index', ['sort' => 'newest']) }}">New Arrivals</a></li>
                        @foreach($navCategories as $navCategory)
                            <li><a href="{{ route('shop.index', ['category' => $navCategory->slug]) }}">{{ $navCategory->name }}</a></li>
                        @endforeach
                        <li><a href="{{ url('/#maithili-stories') }}">Our Story</a></li>
                        <li><a href="{{ url('/#maithili-impact') }}">Impact</a></li>
                        <li><a href="{{ url('/#maithili-contact') }}">Corporate Orders</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- navbar end -->

    </header>
    <!-- header area end -->


    <!-- popup search -->
    <div class="search-popup">
        <button class="close-search"><span class="far fa-times"></span></button>
        <form action="{{ route('shop.index') }}" method="GET" class="maithili-search-form" role="search" autocomplete="off" data-suggestions-url="{{ route('shop.suggestions') }}">
            <div class="form-group">
                <label class="visually-hidden" for="maithili-search-input">Search handcrafted products</label>
                <input id="maithili-search-input" type="search" name="q" class="form-control" placeholder="Search for handcrafted products..." minlength="2" maxlength="100" aria-controls="maithili-search-suggestions" aria-autocomplete="list" aria-expanded="false" required>
                <button type="submit"><i class="far fa-search"></i></button>
            </div>
            <div id="maithili-search-suggestions" class="maithili-search-suggestions" role="listbox" aria-label="Search suggestions" hidden></div>
        </form>
    </div>
    <!-- popup search end -->

    @yield('content')



        <!-- House Of Maithili footer -->
    <footer class="footer-area maithili-footer">
        <div class="container">
            <div class="maithili-footer-grid">
                <div class="maithili-footer-brand">
                    <a href="{{ url('/') }}" class="maithili-footer-logo" aria-label="House Of Maithili home">
                        <img src="{{ asset('frontend/images/house-of-maithili.png') }}" alt="House Of Maithili">
                    </a>
                    <p>Women’s clothing by House Of Maithili. Brand details and store information will be added as they are confirmed.</p>
                </div>
                <nav class="maithili-footer-group" aria-label="Explore House Of Maithili">
                    <h2>Explore</h2>
                    <a href="{{ url('/') }}#maithili-bestsellers">Bestsellers</a>
                    <a href="{{ url('/') }}#maithili-impact">Our Impact</a>
                    <a href="{{ url('/') }}#maithili-as-seen-in">As Seen In</a>
                    <a href="{{ url('/') }}#maithili-testimonials">Customer Reviews</a>
                </nav>
                <div class="maithili-footer-group">
                    <h2>Customer Care</h2>
                    <p>Customer-care pages are not configured yet.</p>
                    <p>Social links will be added when verified profile URLs are available.</p>
                </div>
                <div class="maithili-footer-group" id="maithili-contact">
                    <h2>Contact</h2>
                    <a href="mailto:info@houseofmaithili.com">info@houseofmaithili.com</a>
                    <a href="tel:+918226803011">+91 82268 03011</a>
                    <p>Payment methods will be listed after checkout options are verified.</p>
                </div>
            </div>
            <div class="maithili-footer-bottom">
                <span>© {{ date('Y') }} House Of Maithili</span>
                <span>Payment options and customer-care destinations pending confirmation.</span>
            </div>
        </div>
    </footer>


    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="far fa-arrow-up-from-arc"></i></a>
    <!-- scroll-top end -->


    <!-- modal quick shop-->
    <div class="modal quickview fade" id="quickview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="quickview" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <img src="{{url('/')}}/frontend/images/18.png" alt="#">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h4 class="quickview-title">Special Gift Box</h4>
                                <div class="quickview-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                    <span class="rating-count"> (4 Customer Reviews)</span>
                                </div>
                                <div class="quickview-price">
                                    <h5><del>Rs860</del><span>Rs740</span></h5>
                                </div>
                                <ul class="quickview-list">
                                    <li>Brand:<span>Ricordi</span></li>
                                    <li>Category:<span>Gifts Box</span></li>
                                    <li>Stock:<span class="stock">Available</span></li>
                                    <li>Code:<span>789FGSA</span></li>
                                </ul>
                                <div class="quickview-cart">
                                    <a href="#" class="theme-btn">Add to cart</a>
                                </div>
                                <div class="quickview-social">
                                    <span>Share:</span>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-x-twitter"></i></a>
                                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal quick shop end -->


    <!-- js -->
    <script data-cfasync="false" src="{{url('/')}}/frontend/js/email-decode.min.js"></script><script src="{{url('/')}}/frontend/js/jquery-3.7.1.min.js"></script>
    <script src="{{url('/')}}/frontend/js/modernizr.min.js"></script>
    <script src="{{url('/')}}/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="{{url('/')}}/frontend/js/imagesloaded.pkgd.min.js"></script>
    <script src="{{url('/')}}/frontend/js/jquery.magnific-popup.min.js"></script>
    <script src="{{url('/')}}/frontend/js/isotope.pkgd.min.js"></script>
    <script src="{{url('/')}}/frontend/js/jquery.appear.min.js"></script>
    <script src="{{url('/')}}/frontend/js/jquery.easing.min.js"></script>
    <script src="{{url('/')}}/frontend/js/owl.carousel.min.js"></script>
    <script src="{{url('/')}}/frontend/js/counter-up.js"></script>
    <script src="{{url('/')}}/frontend/js/jquery-ui.min.js"></script>
    <script src="{{url('/')}}/frontend/js/jquery.nice-select.min.js"></script>
    <script src="{{url('/')}}/frontend/js/countdown.min.js"></script>
    <script src="{{url('/')}}/frontend/js/wow.min.js"></script>
    <script src="{{url('/')}}/frontend/js/main.js"></script>
    <script src="{{ asset('frontend/js/shop-search.js') }}" defer></script>



</body></html>
