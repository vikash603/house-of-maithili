<!DOCTYPE html><html lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Multikart admin is super flexible, powerful, clean & modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Multikart admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{url('/')}}/backend/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('/')}}/backend/images/favicon.png" type="image/x-icon">
    <title>Multikart - Premium Admin Template</title>

    <!-- Google font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&display=swap">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">


    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/backend/css/font-awesome.css">

    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/backend/css/flag-icon.css">

    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/backend/css/icofont.css">

    <!-- Prism css-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/backend/css/prism.css">

    <!-- Chartist css -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/backend/css/chartist.css">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/backend/css/bootstrap.css">

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/backend/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/product-catalog.css') }}">
</head>

<body>

    <!-- page-wrapper Start-->
    <div class="page-wrapper">

        <!-- Page Header Start-->
        <div class="page-main-header">
            <div class="main-header-right row">
                <div class="main-header-left d-lg-none w-auto">
                    <div class="logo-wrapper">
                        <a href="index.html">
                            <img class="blur-up lazyloaded d-block d-lg-none" src="{{url('/')}}/frontend/images/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="mobile-sidebar w-auto">
                    <div class="media-body text-end switch-sm">
                        <label class="switch">
                            <a href="javascript:void(0)">
                                <i id="sidebar-toggle" data-feather="align-left"></i>
                            </a>
                        </label>
                    </div>
                </div>
                <div class="nav-right col">
                    <ul class="nav-menus">
                        <li>
                            <form class="form-inline search-form">
                                <div class="form-group">
                                    <input class="form-control-plaintext" type="search" placeholder="Search..">
                                    <span class="d-sm-none mobile-search">
                                        <i data-feather="search"></i>
                                    </span>
                                </div>
                            </form>
                        </li>
                        <li>
                            <a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()">
                                <i data-feather="maximize-2"></i>
                            </a>
                        </li>
                        <li class="onhover-dropdown">
                            <a class="txt-dark" href="javascript:void(0)">
                                <h6>EN</h6>
                            </a>
                            <ul class="language-dropdown onhover-show-div p-20">
                                <li>
                                    <a href="javascript:void(0)" data-lng="en">
                                        <i class="flag-icon flag-icon-is"></i>English</a>
                                </li>
                                
                            </ul>
                        </li>
                        <li class="onhover-dropdown">
                            <i data-feather="bell"></i>
                            <span class="badge badge-pill badge-primary pull-right notification-badge">3</span>
                            <span class="dot"></span>
                            <ul class="notification-dropdown onhover-show-div p-0">
                                <li>Notification <span class="badge badge-pill badge-primary pull-right">3</span></li>
                                <li>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="mt-0">
                                                <span>
                                                    <i class="shopping-color" data-feather="shopping-bag"></i>
                                                </span>Your order ready for Ship..!
                                            </h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="mt-0 txt-success">
                                                <span>
                                                    <i class="download-color font-success" data-feather="download"></i>
                                                </span>Download Complete
                                            </h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="mt-0 txt-danger">
                                                <span>
                                                    <i class="alert-color font-danger" data-feather="alert-circle"></i>
                                                </span>250 MB trash files
                                            </h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="txt-dark"><a href="javascript:void(0)">All</a> notification</li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="right_side_toggle" data-feather="message-square"></i>
                                <span class="dot"></span>
                            </a>
                        </li>
                        <li class="onhover-dropdown">
                            <div class="media align-items-center">
                                <img class="align-self-center pull-right img-50 blur-up lazyloaded" src="{{url('/')}}/backend/images/user3.jpg" alt="header-user">
                                <div class="dotted-animation">
                                    <span class="animate-circle"></span>
                                    <span class="main-circle"></span>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div p-20 profile-dropdown-hover">
                                <li>
                                    <a href="javascript:void(0)">
                                        <i data-feather="user"></i>Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i data-feather="mail"></i>Inbox
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i data-feather="lock"></i>Lock Screen
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i data-feather="settings"></i>Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i data-feather="log-out"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-lg-none mobile-toggle pull-right">
                        <i data-feather="more-horizontal"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header Ends -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            <div class="page-sidebar">
                <div class="main-header-left d-none d-lg-block">
                    <div class="logo-wrapper">
                        <a href="{{url('/')}}/admin">
                            <img class="d-none d-lg-block blur-up lazyloaded" src="{{url('/')}}/frontend/images/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="sidebar custom-scrollbar">
                    <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <ul class="sidebar-menu">
                        <li>
                            <a class="sidebar-header" href="#">
                                <i data-feather="home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="{{ route('banners.index') }}">
                                <i data-feather="image"></i>
                                <span>Home Banners</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="{{ route('stories.index') }}">
                                <i data-feather="film"></i>
                                <span>Our Stories</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="{{ route('home-highlights.index') }}">
                                <i data-feather="star"></i>
                                <span>Home Highlights</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="{{ route('testimonials.index') }}">
                                <i data-feather="message-circle"></i>
                                <span>Testimonials</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="archive"></i>
                                <span>Category</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>

                            <ul class="sidebar-submenu">
                               

                            <li>
                                            <a href="{{url('/')}}/admin/categories">
                                                <i class="fa fa-circle"></i>Category
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{url('/')}}/admin/subcategories">
                                                <i class="fa fa-circle"></i>Sub Category</a>
                                        </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="archive"></i>
                                <span>Products</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>

                            <ul class="sidebar-submenu">
                               

                                <li>
                                            <a href="{{url('/')}}/admin/products">
                                                <i class="fa fa-circle"></i>Product List
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{url('/')}}/admin/products/create">
                                                <i class="fa fa-circle"></i>Add Product
                                            </a>
                                        </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="archive"></i>
                                <span>Orders</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>

                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="order-list.html">
                                        <i class="fa fa-circle"></i>
                                        <span>Order List</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="order-tracking.html">
                                        <i class="fa fa-circle"></i>
                                        <span>Order Tracking</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="order-detail.html">
                                        <i class="fa fa-circle"></i>
                                        <span>Order Details</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="dollar-sign"></i>
                                <span>Sales</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.orders.index') }}">
                                        <i class="fa fa-circle"></i>Orders
                                    </a>
                                </li>
                                <li>
                                    <a href="transactions.html">
                                        <i class="fa fa-circle"></i>Transactions
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="tag"></i>
                                <span>Coupons</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('coupons.index') }}">
                                        <i class="fa fa-circle"></i>List Coupons
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('coupons.create') }}">
                                        <i class="fa fa-circle"></i>Create Coupons
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="clipboard"></i>
                                <span>Pages</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="pages-list.html">
                                        <i class="fa fa-circle"></i>List Page
                                    </a>
                                </li>
                                <li>
                                    <a href="page-create.html">
                                        <i class="fa fa-circle"></i>Create Page
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a class="sidebar-header" href="{{url('/')}}/abouts">
                                <i data-feather="clipboard"></i>
                                <span>About Us</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="{{url('/')}}/termss">
                                <i data-feather="clipboard"></i>
                                <span>Terms and Conditions</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="{{url('/')}}/privacys">
                                <i data-feather="clipboard"></i>
                                <span>Privacy Policy</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="{{url('/')}}/refunds">
                                <i data-feather="clipboard"></i>
                                <span>Return and Refund Policy</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="{{url('/')}}/contacts">
                                <i data-feather="clipboard"></i>
                                <span>Contact Us</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="media.html">
                                <i data-feather="camera"></i>
                                <span>Media</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="align-left"></i>
                                <span>Menus</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="menu-list.html">
                                        <i class="fa fa-circle"></i>Menu Lists
                                    </a>
                                </li>
                                <li>
                                    <a href="create-menu.html">
                                        <i class="fa fa-circle"></i>Create Menu
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="user-plus"></i>
                                <span>Users</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="user-list.html">
                                        <i class="fa fa-circle"></i>User List
                                    </a>
                                </li>
                                <li>
                                    <a href="create-user.html">
                                        <i class="fa fa-circle"></i>Create User
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="users"></i>
                                <span>Vendors</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="list-vendor.html">
                                        <i class="fa fa-circle"></i>Vendor List
                                    </a>
                                </li>
                                <li>
                                    <a href="create-vendors.html">
                                        <i class="fa fa-circle"></i>Create Vendor
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="chrome"></i>
                                <span>Localization</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="translations.html"><i class="fa fa-circle"></i>Translations
                                    </a>
                                </li>
                                <li>
                                    <a href="currency-rates.html"><i class="fa fa-circle"></i>Currency Rates
                                    </a>
                                </li>
                                <li>
                                    <a href="taxes.html"><i class="fa fa-circle"></i>Taxes
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="support-ticket.html"><i data-feather="phone"></i><span>Support Ticket</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="reports.html"><i data-feather="bar-chart"></i><span>Reports</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)"><i data-feather="settings"></i><span>Settings</span><i class="fa fa-angle-right pull-right"></i></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="profile.html"><i class="fa fa-circle"></i>Profile
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="invoice.html"><i data-feather="archive"></i><span>Invoice</span></a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="forgot-password.html">
                                <i data-feather="key"></i>
                                <span>Forgot Password</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-header" href="login.html">
                                <i data-feather="log-in"></i>
                                <span>Login</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page Sidebar Ends-->


            @yield('content')



   <!-- footer start-->
   <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 footer-copyright text-start">
                            <p class="mb-0">Copyright 2026 © Multikart All rights reserved.</p>
                        </div>
                        <div class="col-md-6 pull-right text-end">
                            <p class=" mb-0">Hand crafted & made with<i class="ri-heart-line"></i></p>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- footer end-->
        </div>
    </div>


     <!-- Modal -->
     <div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Category</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="categoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">

                <div class="modal-body">

                    <!-- NAME -->
                    <div class="form-group mb-3">
                        <label>Category Name</label>
                        <input type="text"
                               name="name"
                               id="cat_name"
                               class="form-control"
                               placeholder="Enter category name"
                               required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="cat_sort_order">Display order</label>
                        <input type="number" name="sort_order" id="cat_sort_order" class="form-control" min="0" max="65535" value="0" inputmode="numeric">
                        <small class="text-muted">Lower numbers appear first in the shop and category navigation.</small>
                    </div>

                    <!-- IMAGE -->
                    <div class="form-group mb-3">
                        <label>Category Image</label>
                        <input type="file"
                               name="image"
                               class="form-control"
                               onchange="previewImage(event)">

                        <!-- Image Preview -->
                        <div class="mt-2">
                            <img id="previewImg"
                                 src=""
                                 style="display:none; width:70px; height:70px; object-fit:cover;">
                        </div>
                    </div>

                    <!-- STATUS -->
                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" id="cat_status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


    <div class="bottom-space"></div>

    <script>
function openAddModal() {
    const modal = new bootstrap.Modal(document.getElementById('categoryModal'));

    document.getElementById('modalTitle').innerText = 'Add Category';

    let form = document.getElementById('categoryForm');

    // ✅ correct route
    form.action = "{{ route('categories.store') }}";

    // ✅ method reset (remove PUT)
    document.getElementById('methodField').value = "POST";

    // ✅ reset fields
    document.getElementById('cat_name').value = '';
    document.getElementById('cat_status').value = 1;
    document.getElementById('cat_sort_order').value = 0;

    // ✅ 🔥 VERY IMPORTANT (file reset)
    document.querySelector('input[name="image"]').value = '';

    // preview reset
    let img = document.getElementById('previewImg');
    img.src = '';
    img.style.display = "none";

    modal.show();
}


function openEditModal(id, name, status, image, sortOrder) {
    const modal = new bootstrap.Modal(document.getElementById('categoryModal'));

    document.getElementById('modalTitle').innerText = 'Edit Category';

    let form = document.getElementById('categoryForm');

    form.action = "{{ url('admin/categories') }}/" + id;

    // ✅ PUT method
    document.getElementById('methodField').value = "PUT";

    // fill data
    document.getElementById('cat_name').value = name;
    document.getElementById('cat_status').value = status;
    document.getElementById('cat_sort_order').value = sortOrder || 0;

    // ✅ 🔥 VERY IMPORTANT (file reset)
    document.querySelector('input[name="image"]').value = '';

    // image preview
    let img = document.getElementById('previewImg');

    if (image && image !== "null") {
        img.src = "{{ asset('uploads/category') }}/" + image;
        img.style.display = "block";
    } else {
        img.src = '';
        img.style.display = "none";
    }

    modal.show();
}

function openEditModalFromButton(button) {
    openEditModal(button.dataset.id, button.dataset.name, button.dataset.status, button.dataset.image, button.dataset.sortOrder);
}


// ✅ image preview
function previewImage(event) {
    let file = event.target.files[0];

    if (!file) return;

    let reader = new FileReader();

    reader.onload = function(e){
        let img = document.getElementById('previewImg');
        img.src = e.target.result;
        img.style.display = "block";
    }

    reader.readAsDataURL(file);
}
</script>

<script>
function deleteConfirm(id) {
    Swal.fire({
        title: 'Delete?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
@endif
</script>

<script>
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: "{{ session('error') }}"
});
@endif
</script>
    <!-- latest jquery-->
    <script src="{{url('/')}}/backend/js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap js-->
    <script src="{{url('/')}}/backend/js/bootstrap.bundle.min.js"></script>

    <!-- feather icon js-->
    <script src="{{url('/')}}/backend/js/feather.min.js"></script>
    <script src="{{url('/')}}/backend/js/feather-icon.js"></script>

    <!-- Sidebar jquery-->
    <script src="{{url('/')}}/backend/js/sidebar-menu.js"></script>

    <!--chartist js-->
    <script src="{{url('/')}}/backend/js/chartist.js"></script>

    <!--chartjs js-->
    <script src="{{url('/')}}/backend/js/chart.min.js"></script>

    <!-- lazyload js-->
    <script src="{{url('/')}}/backend/js/lazysizes.min.js"></script>

    <!--copycode js-->
    <script src="{{url('/')}}/backend/js/prism.min.js"></script>
    <script src="{{url('/')}}/backend/js/clipboard.min.js"></script>
    <script src="{{url('/')}}/backend/js/custom-card.js"></script>

    <!--counter js-->
    <script src="{{url('/')}}/backend/js/jquery.waypoints.min.js"></script>
    <script src="{{url('/')}}/backend/js/jquery.counterup.min.js"></script>
    <script src="{{url('/')}}/backend/js/counter-custom.js"></script>

    <!--peity chart js-->
    <script src="{{url('/')}}/backend/js/peity.jquery.js"></script>

    <!-- Apex Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!--sparkline chart js-->
    <script src="{{url('/')}}/backend/js/sparkline.js"></script>

    <!--Customizer admin-->
    <script src="{{url('/')}}/backend/js/admin-customizer.js"></script>

    <!--dashboard custom js-->
    <script src="{{url('/')}}/backend/js/default.js"></script>

    <!--right sidebar js-->
    <script src="{{url('/')}}/backend/js/chat-menu.js"></script>

    <!--height equal js-->
    <script src="{{url('/')}}/backend/js/height-equal.js"></script>

    <!-- lazyload js-->
    <script src="{{url('/')}}/backend/js/lazysizes.min.js"></script>

    <!--script admin-->
    <script src="{{url('/')}}/backend/js/admin-script.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @yield('js')


</body></html>
