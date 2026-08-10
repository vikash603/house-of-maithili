
@extends('frontend.layout.app')
@section('content')

    <main class="main">

        <!-- category area -->
        <div class="category-area pt-30">
            <div class="container">
                <div class="category-slider owl-carousel owl-theme">
                    <div class="category-item">
                        <a href="#">
                            <div class="category-info">
                                <div class="icon">
                                    <img src="{{url('/')}}/frontend/images/gift-box.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Gifts Box</h4>
                                    <p>30 Items</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="category-item">
                        <a href="#">
                            <div class="category-info">
                                <div class="icon">
                                    <img src="{{url('/')}}/frontend/images/home.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Home & Living Gifts</h4>
                                    <p>25 Items</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="category-item">
                        <a href="#">
                            <div class="category-info">
                                <div class="icon">
                                    <img src="{{url('/')}}/frontend/images/jewelry.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Jewelry & Accessories</h4>
                                    <p>15 Items</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="category-item">
                        <a href="#">
                            <div class="category-info">
                                <div class="icon">
                                    <img src="{{url('/')}}/frontend/images/garment.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Garment Care</h4>
                                    <p>05 Items</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="category-item">
                        <a href="#">
                            <div class="category-info">
                                <div class="icon">
                                    <img src="{{url('/')}}/frontend/images/office.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Office & Stationery</h4>
                                    <p>30 Items</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="category-item">
                        <a href="#">
                            <div class="category-info">
                                <div class="icon">
                                    <img src="{{url('/')}}/frontend/images/gift.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Occasion Gifts</h4>
                                    <p>12 Items</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="category-item">
                        <a href="#">
                            <div class="category-info">
                                <div class="icon">
                                    <img src="{{url('/')}}/frontend/images/gift-2.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Personalised Gifts</h4>
                                    <p>08 Items</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- category area end-->


        <!-- hero slider -->
        <div class="hero-section hs-1 mt-30">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="hero-banner">
                            <img src="{{url('/')}}/frontend/images/1.jpeg" alt="">
                            <div class="banner-content">
                                <p>Start Rs10.99</p>
                                <h3>Special Gifts Box For Your Love</h3>
                                <a href="#" class="theme-btn">Shop Now<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="hero-slider owl-carousel owl-theme">
                            <div class="hero-single" style="background-image: url({{url('/')}}/frontend/images/banner2.png);">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6">
                                            <div class="hero-content">
                                                <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Best Gift Shop</h6>
                                                <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                    Choose Perfect <span>Gifts</span> From Us
                                                </h1>
                                                <p data-animation="fadeInLeft" data-delay=".75s">
                                                    There are many variations of passages orem psum available but the majority
                                                    have suffered.
                                                </p>
                                                <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                    <a href="#" class="theme-btn">Shop Now<i class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-single" style="background-image: url({{url('/')}}/frontend/images/banner3.png);">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6">
                                            <div class="hero-content">
                                                <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Best Gift Shop</h6>
                                                <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                    Choose Perfect <span>Gifts</span> From Us
                                                </h1>
                                                <p data-animation="fadeInLeft" data-delay=".75s">
                                                    There are many variations of passages orem psum available but the majority
                                                    have suffered.
                                                </p>
                                                <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                    <a href="#" class="theme-btn">Shop Now<i class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-single" style="background-image: url({{url('/')}}/frontend/images/banner1.png);">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6">
                                            <div class="hero-content">
                                                <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Best Gift Shop</h6>
                                                <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                    Choose Perfect <span>Gifts</span> From Us
                                                </h1>
                                                <p data-animation="fadeInLeft" data-delay=".75s">
                                                    There are many variations of passages orem psum available but the majority
                                                    have suffered.
                                                </p>
                                                <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                    <a href="#" class="theme-btn">Shop Now<i class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-single" style="background-image: url({{url('/')}}/frontend/images/slider-4.jpg);">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6">
                                            <div class="hero-content">
                                                <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Best Gift Shop</h6>
                                                <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                    Choose Perfect <span>Gifts</span> From Us
                                                </h1>
                                                <p data-animation="fadeInLeft" data-delay=".75s">
                                                    There are many variations of passages orem psum available but the majority
                                                    have suffered.
                                                </p>
                                                <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                    <a href="#" class="theme-btn">Shop Now<i class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero slider end -->


        <!-- feature area -->
        <div class="feature-area py-100">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="feature-wrap">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fal fa-truck"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Free Delivery</h4>
                                    <p>Orders Over Rs120</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fal fa-sync"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Get Refund</h4>
                                    <p>Within 30 Days Returns</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fal fa-wallet"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Safe Payment</h4>
                                    <p>100% Secure Payment</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fal fa-headset"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>24/7 Support</h4>
                                    <p>Feel Free To Call Us</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- feature area end -->


        <!-- product-area -->
        <div class="product-area pb-100">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4">
                        <div class="col-12 wow fadeInDown" data-wow-delay=".25s">
                            <div class="site-heading mb-0 pe-2">
                                <span class="site-title-tagline">Premium Gifts</span>
                                <h2 class="site-title">Experience <span>premium gifts</span> and products</h2>
                                <p>It is a long established fact that a reader will by the readable content of a page
                                    when looking the majority have suffered alteration in some form at its layout ure there
                                    readable content of a page when looking at its layout
                                    anything hidden in the middle.
                                </p>
                                <a href="#" class="theme-btn mt-30">Explore More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="product-wrap wow fadeInUp" data-wow-delay=".25s">
                            <div class="product-slider2 owl-carousel owl-theme">
                                <div class="product-item">
                                    <div class="product-img">
                                        <span class="type new">New</span>
                                        <a href="#"><img src="{{url('/')}}/frontend/images/6.jpeg" alt=""></a>
                                        <div class="product-action-wrap">
                                            <div class="product-action">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-info">
                                            <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                            <div class="product-rate">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="product-price">
                                                <span>Rs250.00</span>
                                            </div>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                    <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-item">
                                    <div class="product-img">
                                        <span class="type hot">Hot</span>
                                        <a href="#"><img src="{{url('/')}}/frontend/images/7.jpeg" alt=""></a>
                                        <div class="product-action-wrap">
                                            <div class="product-action">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-info">
                                            <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                            <div class="product-rate">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="product-price">
                                                <span>Rs250.00</span>
                                            </div>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                    <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-item">
                                    <div class="product-img">
                                        <span class="type oos">Out Of Stock</span>
                                        <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt=""></a>
                                        <div class="product-action-wrap">
                                            <div class="product-action">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-info">
                                            <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                            <div class="product-rate">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="product-price">
                                                <span>Rs250.00</span>
                                            </div>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                    <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-item">
                                    <div class="product-img">
                                        <span class="type discount">10% Off</span>
                                        <a href="#"><img src="{{url('/')}}/frontend/images/2.jpeg" alt=""></a>
                                        <div class="product-action-wrap">
                                            <div class="product-action">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-info">
                                            <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                            <div class="product-rate">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="product-price">
                                                <del>Rs250.00</del>
                                                <span>Rs190.00</span>
                                            </div>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                    <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-item">
                                    <div class="product-img">
                                        <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt=""></a>
                                        <div class="product-action-wrap">
                                            <div class="product-action">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-info">
                                            <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                            <div class="product-rate">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="product-price">
                                                <span>Rs250.00</span>
                                            </div>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                    <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-item">
                                    <div class="product-img">
                                        <a href="#"><img src="{{url('/')}}/frontend/images/06.png" alt=""></a>
                                        <div class="product-action-wrap">
                                            <div class="product-action">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-info">
                                            <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                            <div class="product-rate">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="product-price">
                                                <span>Rs250.00</span>
                                            </div>
                                        </div>
                                        <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                    <i class="far fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- product-area end -->


        <!-- small banner -->
        <div class="small-banner pb-100">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="row g-4">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="banner-item">
                            <img src="{{url('/')}}/frontend/images/10.jpeg" alt="">
                            <div class="banner-content">
                                <p>Gift Box</p>
                                <h3>Awesome Gifts Box <br> Collectons</h3>
                                <a href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="banner-item">
                            <img src="{{url('/')}}/frontend/images/11.jpeg" alt="">
                            <div class="banner-content">
                                <p>Occasion Gift</p>
                                <h3>Best Occasion Gifts <br> Collections</h3>
                                <a href="#">Discover Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="banner-item">
                            <img src="{{url('/')}}/frontend/images/12.jpeg" alt="">
                            <div class="banner-content">
                                <p>Hot Sale</p>
                                <h3>Combo Sets Gift Box <br> Up To <span>50%</span> Off</h3>
                                <a href="#">Discover Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- small banner end -->


        <!-- trending item -->
        <div class="product-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInDown" data-wow-delay=".25s">
                        <div class="site-heading-inline">
                            <h2 class="site-title">Trending Items</h2>
                            <a href="#">View More <i class="fas fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="product-wrap wow fadeInUp" data-wow-delay=".25s">
                    <div class="product-slider owl-carousel owl-theme">
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type new">New</span>
                                <a href="#"><img src="{{url('/')}}/frontend/images/6.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <span>Rs250.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type hot">Hot</span>
                                <a href="#"><img src="{{url('/')}}/frontend/images/7.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <span>Rs250.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type oos">Out Of Stock</span>
                                <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <span>Rs250.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type discount">10% Off</span>
                                <a href="#"><img src="{{url('/')}}/frontend/images/2.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <del>Rs250.00</del>
                                        <span>Rs190.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <span>Rs250.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <a href="#"><img src="{{url('/')}}/frontend/images/06.png" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <span>Rs250.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- trending item end -->


        <!-- video area -->
        <div class="video-area py-100">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4">
                        <div class="site-heading mb-0 wow fadeInLeft" data-wow-delay=".25s">
                            <span class="site-title-tagline">Latest Video</span>
                            <h2 class="site-title">What makes us <span>different check</span> our video</h2>
                            <p>
                                There are many variations of passages available but the majority have suffered alteration in some form by injected humour randomised words which don't look even slightly you are going to use a passage believable.
                            </p>
                            <a href="#" class="theme-btn mt-20">Shop Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="video-content wow fadeInRight" data-wow-delay=".25s" style="background-image: url({{url('/')}}/frontend/images/01.jpg);">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <div class="video-wrapper">
                                        <a class="play-btn popup-youtube" href="https://www.youtube.com/watch?v=ckHzmP1evNU">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- video area end -->


        <!-- popular item -->
        <div class="product-area pb-100">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="small-banner mt-2 wow fadeInLeft" data-wow-delay=".25s">
                            <div class="banner-item">
                                <img src="{{url('/')}}/frontend/images/side-banner.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-12 wow fadeInDown" data-wow-delay=".25s">
                                <div class="site-heading-inline item-tab">
                                    <h2 class="site-title">Popular Items</h2>
                                    <ul class="nav nav-pills" id="item-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="item-tab1" data-bs-toggle="pill" data-bs-target="#pill-item-tab1" type="button" role="tab" aria-controls="pill-item-tab1" aria-selected="true">Home & Living</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="item-tab2" data-bs-toggle="pill" data-bs-target="#pill-item-tab2" type="button" role="tab" aria-controls="pill-item-tab2" aria-selected="false">Garment Care</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="item-tab3" data-bs-toggle="pill" data-bs-target="#pill-item-tab3" type="button" role="tab" aria-controls="pill-item-tab3" aria-selected="false">Gifts Box</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="item-tab4" data-bs-toggle="pill" data-bs-target="#pill-item-tab4" type="button" role="tab" aria-controls="pill-item-tab4" aria-selected="false">Occasion Gifts</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content wow fadeInUp" data-wow-delay=".25s" id="item-tabContent">
                            <div class="tab-pane show active" id="pill-item-tab1" role="tabpanel" aria-labelledby="item-tab1" tabindex="0">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type new">New</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/3.jpeg" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type hot">Hot</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/10.jpeg" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type oos">Out Of Stock</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/11.jpeg" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type discount">10% Off</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/12.jpeg" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <del>Rs250.00</del>
                                                        <span>Rs190.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="pill-item-tab2" role="tabpanel" aria-labelledby="item-tab2" tabindex="0">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type new">New</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/12.jpeg" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type hot">Hot</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/16.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type oos">Out Of Stock</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/17.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type discount">10% Off</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/18.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <del>Rs250.00</del>
                                                        <span>Rs190.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="pill-item-tab3" role="tabpanel" aria-labelledby="item-tab3" tabindex="0">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type new">New</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/19.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type hot">Hot</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/20.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type oos">Out Of Stock</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/21.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type discount">10% Off</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/22.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <del>Rs250.00</del>
                                                        <span>Rs190.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="pill-item-tab4" role="tabpanel" aria-labelledby="item-tab4" tabindex="0">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type new">New</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/11.jpeg" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type hot">Hot</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/25.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type oos">Out Of Stock</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/26.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rs250.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="type discount">10% Off</span>
                                                <a href="#"><img src="{{url('/')}}/frontend/images/27.png" alt=""></a>
                                                <div class="product-action-wrap">
                                                    <div class="product-action">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="top" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                                        <a href="#" data-bs-placement="top" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-info">
                                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <del>Rs250.00</del>
                                                        <span>Rs190.00</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                                            <i class="far fa-shopping-bag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- popular item end -->


        <!-- big banner -->
        <div class="big-banner">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="banner-wrap" style="background-image: url({{url('/')}}/frontend/images/big-banner.jpg);">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="banner-content">
                                <div class="banner-info">
                                    <h6>Mega Collections</h6>
                                    <h2>Huge Sale Up To <span>40%</span> Off</h2>
                                    <p>at our outlet stores</p>
                                </div>
                                <a href="#" class="theme-btn">Shop Now<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- big banner end -->


        <!-- funfact -->
        <div class="funfact pt-100">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-5">
                        <div class="funfact-product wow fadeInLeft" data-wow-delay=".25s">
                            <ul class="nav nav-underline nav-justified mb-3" id="pills-tab-plist" role="tablist">
                                <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-plist-tab1" data-bs-toggle="pill" data-bs-target="#pills-plist1" type="button" role="tab" aria-controls="pills-plist1" aria-selected="true">
                                    On Sale
                                </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-plist-tab2" data-bs-toggle="pill" data-bs-target="#pills-plist2" type="button" role="tab" aria-controls="pills-plist2" aria-selected="false">
                                    Best Seller
                                </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-plist-tab3" data-bs-toggle="pill" data-bs-target="#pills-plist3" type="button" role="tab" aria-controls="pills-plist3" aria-selected="false">
                                    Top Rated
                                </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent-plist">
                                <div class="tab-pane fade show active" id="pills-plist1" role="tabpanel" aria-labelledby="pills-plist-tab1" tabindex="0">
                                    <div class="product-list-box">
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/6.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/7.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-plist2" role="tabpanel" aria-labelledby="pills-plist-tab2" tabindex="0">
                                    <div class="product-list-box">
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/6.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/7.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-plist3" role="tabpanel" aria-labelledby="pills-plist-tab3" tabindex="0">
                                    <div class="product-list-box">
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/6.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/7.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                        <div class="product-list-item">
                                            <div class="product-list-img">
                                                <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt="#"></a>
                                            </div>
                                            <div class="product-list-content">
                                                <h4><a href="#">Special Gift Box</a></h4>
                                                <div class="product-list-rate">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <div class="product-list-price">
                                                    <del>60.00</del><span>Rs40.00</span>
                                                </div>
                                            </div>
                                            <a href="#" class="product-list-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="funfact-content wow fadeInRight" data-wow-delay=".25s">
                            <div class="site-heading">
                                <span class="site-title-tagline">Our Funfact</span>
                                <h2 class="site-title">We Are <span>Tofa Guru, Amaze</span> With Perfect Gift.</h2>
                                <p>
                                    There are many variations of passages available but the majority have suffered alteration in some 
                                    form by injected humour randomised words which don't look even If you are going to use a passage
                                    you need to be sure there isn't anything embarrassing hidden in the middle of text
                                    slightly making this the first true generator on the you are going to use a passage believable.
                                </p>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="counter-box">
                                        <div class="icon">
                                            <img src="{{url('/')}}/frontend/images/sale.svg" alt="">
                                        </div>
                                        <div class="counter-info">
                                            <div class="counter-amount">
                                                <span class="counter" data-count="+" data-to="50" data-speed="3000">50</span>
                                                <span class="counter-sign">k</span>
                                            </div>
                                            <h6 class="title">Total Sales </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="counter-box">
                                        <div class="icon">
                                            <img src="{{url('/')}}/frontend/images/rate.svg" alt="">
                                        </div>
                                        <div class="counter-info">
                                            <div class="counter-amount">
                                                <span class="counter" data-count="+" data-to="90" data-speed="3000">90</span>
                                                <span class="counter-sign">k</span>
                                            </div>
                                            <h6 class="title">Happy Clients</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="counter-box">
                                        <div class="icon">
                                            <img src="{{url('/')}}/frontend/images/employee.svg" alt="">
                                        </div>
                                        <div class="counter-info">
                                            <div class="counter-amount">
                                                <span class="counter" data-count="+" data-to="150" data-speed="3000">150</span>
                                                <span class="counter-sign">+</span>
                                            </div>
                                            <h6 class="title">Team Workers</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- funfact end -->


        <!-- deal area -->
        <div class="deal-area deal-bg deal-negative py-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-delay=".25s">
                        <div class="site-heading text-center mb-2">
                            <h2 class="site-title text-white">Best Deals For This Week</h2>
                            <p class="text-white">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                        </div>
                    </div>
                </div>
                <div class="product-wrap wow fadeInUp" data-wow-delay=".25s">
                    <div class="col-lg-5 mx-auto">
                        <div class="deal-countdown">
                            <div class="countdown" data-countdown="2025/12/30"></div>
                        </div>
                    </div>
                    <div class="product-slider owl-carousel owl-theme">
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type new">New</span>
                                <a href="#"><img src="{{url('/')}}/frontend/images/6.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <del>Rs250.00</del>
                                        <span>Rs190.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type hot">Hot</span>
                                <a href="#"><img src="{{url('/')}}/frontend/images/7.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <del>Rs250.00</del>
                                        <span>Rs190.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type oos">Out Of Stock</span>
                                <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <del>Rs250.00</del>
                                        <span>Rs190.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type discount">10% Off</span>
                                <a href="#"><img src="{{url('/')}}/frontend/images/2.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <del>Rs250.00</del>
                                        <span>Rs190.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <a href="#"><img src="{{url('/')}}/frontend/images/5.jpeg" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <del>Rs250.00</del>
                                        <span>Rs190.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-img">
                                <a href="#"><img src="{{url('/')}}/frontend/images/06.png" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-info">
                                    <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                    <div class="product-rate">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="product-price">
                                        <del>Rs250.00</del>
                                        <span>Rs190.00</span>
                                    </div>
                                </div>
                                <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                            <i class="far fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- deal area end -->

        
        <!-- about area -->
        <div class="about-area pb-120 mt-40">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                            <div class="about-img">
                                <div class="img-1">
                                    <img src="{{url('/')}}/frontend/images/01_3.jpg" alt="">
                                </div>
                                <img class="img-2" src="{{url('/')}}/frontend/images/02_2.jpg" alt="">
                                <img class="img-3" src="{{url('/')}}/frontend/images/03.jpg" alt="">
                            </div>
                            <div class="about-experience">
                                <div class="about-experience-icon">
                                    <img src="{{url('/')}}/frontend/images/experience.svg" alt="">
                                </div>
                                <b>30 Years Of <br> Experience</b>
                            </div>
                            <div class="about-shape">
                                <img src="{{url('/')}}/frontend/images/01.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline justify-content-start">
                                    <i class="flaticon-drive"></i> About Us
                                </span>
                                <h2 class="site-title">
                                    We Provide Best And Quality <span>Gifts Box</span> Product For You
                                </h2>
                            </div>
                            <p>
                                We are standard text ever since the when an unknown printer took a galley of type and
                                scrambled it to make a type
                                specimen book. It has survived not only five but also the leap into electronic remaining
                                essentially by injected humour unchanged.
                            </p>
                            <div class="about-list">
                                <ul>
                                    <li><i class="fas fa-check-double"></i> Streamlined Shipping Experience</li>
                                    <li><i class="fas fa-check-double"></i> Affordable Modern Design</li>
                                    <li><i class="fas fa-check-double"></i> Competitive Price & Easy To Shop</li>
                                    <li><i class="fas fa-check-double"></i> We Made Awesome Products</li>
                                </ul>
                            </div>
                            <a href="#" class="theme-btn mt-4">Discover More<i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->


        <!-- choose-area -->
        <div class="choose-area bg py-80">
            <div class="container">
                <div class="row g-4 align-items-center wow fadeInDown" data-wow-delay=".25s">
                    <div class="col-lg-4">
                        <span class="site-title-tagline">Why Choose Us</span>
                        <h2 class="site-title">We Provide Premium Quality Gifts For You</h2>
                    </div>
                    <div class="col-lg-4">
                        <div class="choose-img">
                            <img src="{{url('/')}}/frontend/images/01_1.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p>There are many variations of passages available but the majority have suffered you are going
                            to use a passage you need to be sure alteration in some form by injected humour randomised
                            words even slightly believable.</p>
                    </div>
                </div>
                <div class="choose-content wow fadeInUp" data-wow-delay=".25s">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="choose-item">
                                <div class="choose-icon">
                                    <img src="{{url('/')}}/frontend/images/warranty.svg" alt="">
                                </div>
                                <div class="choose-info">
                                    <h4>Trusted Partner</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="choose-item">
                                <div class="choose-icon">
                                    <img src="{{url('/')}}/frontend/images/price.svg" alt="">
                                </div>
                                <div class="choose-info">
                                    <h4>Affordable Price</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="choose-item">
                                <div class="choose-icon">
                                    <img src="{{url('/')}}/frontend/images/delivery.svg" alt="">
                                </div>
                                <div class="choose-info">
                                    <h4>Free Shipping</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- choose-area end-->
         

        <!-- gallery-area -->
        <div class="gallery-area py-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Our Gallery</span>
                            <h2 class="site-title">Let's Check Our Photo <span>Gallery</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row g-4 popup-gallery">
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{url('/')}}/frontend/images/01_2.jpg" alt="">
                                <a class="popup-img gallery-link" href="assets/img/gallery/01.jpg"><i class="fal fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{url('/')}}/frontend/images/02.jpg" alt="">
                                <a class="popup-img gallery-link" href="assets/img/gallery/02.jpg"><i class="fal fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{url('/')}}/frontend/images/03_3.jpg" alt="">
                                <a class="popup-img gallery-link" href="assets/img/gallery/03.jpg"><i class="fal fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{url('/')}}/frontend/images/04.jpg" alt="">
                                <a class="popup-img gallery-link" href="assets/img/gallery/04.jpg"><i class="fal fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-6">
                        <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{url('/')}}/frontend/images/05.jpg" alt="">
                                <a class="popup-img gallery-link" href="assets/img/gallery/05.jpg"><i class="fal fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{url('/')}}/frontend/images/06.jpg" alt="">
                                <a class="popup-img gallery-link" href="assets/img/gallery/06.jpg"><i class="fal fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{url('/')}}/frontend/images/07.jpg" alt="">
                                <a class="popup-img gallery-link" href="assets/img/gallery/07.jpg"><i class="fal fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- gallery-area end -->


        <!-- testimonial area -->
        <div class="testimonial-area bg ts-bg py-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-delay=".25s">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Testimonials</span>
                            <h2 class="site-title">What Our Client <span>Say's</span> About Us</h2>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">
                    <div class="testimonial-item">
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="{{url('/')}}/frontend/images/14.jpeg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Sylvia H Green</h4>
                                <p>Customer</p>
                            </div>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of long passages available but the content majority have
                                suffered to the editor page when looking at its layout alteration in some injected.
                            </p>
                        </div>
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote-icon"><img src="{{url('/')}}/frontend/images/quote.svg" alt=""></div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="{{url('/')}}/frontend/images/02_3.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Gordo Novak</h4>
                                <p>Customer</p>
                            </div>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of long passages available but the content majority have
                                suffered to the editor page when looking at its layout alteration in some injected.
                            </p>
                        </div>
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote-icon"><img src="{{url('/')}}/frontend/images/quote.svg" alt=""></div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="{{url('/')}}/frontend/images/03_2.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Reid E Butt</h4>
                                <p>Customer</p>
                            </div>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of long passages available but the content majority have
                                suffered to the editor page when looking at its layout alteration in some injected.
                            </p>
                        </div>
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote-icon"><img src="{{url('/')}}/frontend/images/quote.svg" alt=""></div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="{{url('/')}}/frontend/images/04_1.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Parker Jimenez</h4>
                                <p>Customer</p>
                            </div>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of long passages available but the content majority have
                                suffered to the editor page when looking at its layout alteration in some injected.
                            </p>
                        </div>
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote-icon"><img src="{{url('/')}}/frontend/images/quote.svg" alt=""></div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="{{url('/')}}/frontend/images/05_1.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Heruli Nez</h4>
                                <p>Customer</p>
                            </div>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of long passages available but the content majority have
                                suffered to the editor page when looking at its layout alteration in some injected.
                            </p>
                        </div>
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote-icon"><img src="{{url('/')}}/frontend/images/quote.svg" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- testimonial area end -->


        <!-- blog area -->
        <div class="blog-area py-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Our Blog</span>
                            <h2 class="site-title">Our Latest News & <span>Blog</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="blog-item-img">
                                <img src="{{url('/')}}/frontend/images/13.jpeg" alt="Thumb">
                                <span class="blog-date"><i class="far fa-calendar-alt"></i> Aug 12, 2024</span>
                            </div>
                            <div class="blog-item-info">
                                <div class="blog-item-meta">
                                    <ul>
                                        <li><a href="#"><i class="far fa-user-circle"></i> By Alicia Davis</a></li>
                                        <li><a href="#"><i class="far fa-comments"></i> 2.5k Comments</a></li>
                                    </ul>
                                </div>
                                <h4 class="blog-title">
                                    <a href="#">There are many variations passage available majority suffered.</a>
                                </h4>
                                <p>There are many variations available the majority have suffered alteration randomised
                                    words.</p>
                                <a class="theme-btn" href="#">Read More<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="blog-item-img">
                                <img src="{{url('/')}}/frontend/images/14.jpeg" alt="Thumb">
                                <span class="blog-date"><i class="far fa-calendar-alt"></i> Aug 15, 2024</span>
                            </div>
                            <div class="blog-item-info">
                                <div class="blog-item-meta">
                                    <ul>
                                        <li><a href="#"><i class="far fa-user-circle"></i> By Alicia Davis</a></li>
                                        <li><a href="#"><i class="far fa-comments"></i> 3.1k Comments</a></li>
                                    </ul>
                                </div>
                                <h4 class="blog-title">
                                    <a href="#">Contrary to popular belief making simply random piece latin.</a>
                                </h4>
                                <p>There are many variations available the majority have suffered alteration randomised
                                    words.</p>
                                <a class="theme-btn" href="#">Read More<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="blog-item-img">
                                <img src="{{url('/')}}/frontend/images/17.jpeg" alt="Thumb">
                                <span class="blog-date"><i class="far fa-calendar-alt"></i> Aug 18, 2024</span>
                            </div>
                            <div class="blog-item-info">
                                <div class="blog-item-meta">
                                    <ul>
                                        <li><a href="#"><i class="far fa-user-circle"></i> By Alicia Davis</a></li>
                                        <li><a href="#"><i class="far fa-comments"></i> 1.6k Comments</a></li>
                                    </ul>
                                </div>
                                <h4 class="blog-title">
                                    <a href="#"> If you are going use passage you need sure there middle text.</a>
                                </h4>
                                <p>There are many variations available the majority have suffered alteration randomised
                                    words.</p>
                                <a class="theme-btn" href="#">Read More<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- blog area end -->


        <!-- newsletter area -->
        <div class="newsletter-area pb-100">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="newsletter-wrap">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <div class="newsletter-content">
                                <h3>Get <span>20%</span> Off Discount Coupon</h3>
                                <p>By Subscribe Our Newsletter</p>
                                <div class="subscribe-form">
                                    <form action="#">
                                        <input type="email" class="form-control" placeholder="Your Email Address">
                                        <button class="theme-btn" type="submit">
                                            Subscribe <i class="far fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- newsletter area end -->


        <!-- brand area -->
        <div class="brand-area bg pt-50 pb-50">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h2 class="site-title">Trusted by over <span>4.5k+</span> companies</h2>
                        </div>
                    </div>
                </div>
                <div class="brand-slider owl-carousel owl-theme">
                    <div class="brand-item">
                        <img src="{{url('/')}}/frontend/images/01_1.png" alt="">
                    </div>
                    <div class="brand-item">
                        <img src="{{url('/')}}/frontend/images/02.png" alt="">
                    </div>
                    <div class="brand-item">
                        <img src="{{url('/')}}/frontend/images/03.png" alt="">
                    </div>
                    <div class="brand-item">
                        <img src="{{url('/')}}/frontend/images/04.png" alt="">
                    </div>
                    <div class="brand-item">
                        <img src="{{url('/')}}/frontend/images/05.png" alt="">
                    </div>
                    <div class="brand-item">
                        <img src="{{url('/')}}/frontend/images/06_1.png" alt="">
                    </div>
                </div>
                <div class="text-center">
                    <a href="#" class="theme-btn">View All Brands <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <!-- brand area end -->

    </main>

@endsection