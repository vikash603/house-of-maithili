@extends('backend.layout.app')
@section('content')

            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Dashboard
                                        <small>Tofaguru Admin panel</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden">
                                <div class="warning-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center">
                                                <i data-feather="navigation" class="font-warning"></i>
                                            </div>
                                        </div>
                                        <div class="media-body media-doller">
                                            <span class="m-0">Earnings</span>
                                            <h3 class="mb-0">Rs <span class="counter">6659</span><small> This
                                                    Month</small>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden">
                                <div class="secondary-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center">
                                                <i data-feather="box" class="font-secondary"></i>
                                            </div>
                                        </div>
                                        <div class="media-body media-doller">
                                            <span class="m-0">Products</span>
                                            <h3 class="mb-0">Rs <span class="counter">9856</span><small> This
                                                    Month</small>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden">
                                <div class="primary-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center"><i data-feather="message-square" class="font-primary"></i></div>
                                        </div>
                                        <div class="media-body media-doller"><span class="m-0">Messages</span>
                                            <h3 class="mb-0">Rs <span class="counter">893</span><small> This
                                                    Month</small></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden">
                                <div class="danger-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center"><i data-feather="users" class="font-danger"></i></div>
                                        </div>
                                        <div class="media-body media-doller"><span class="m-0">New Vendors</span>
                                            <h3 class="mb-0">Rs <span class="counter">5631</span><small> This
                                                    Month</small></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Market Value</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="market-chart"></div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                                        <pre><code class="language-html" id="example-head"><!-- Cod Box Copy begin -->
<div class="market-chart"></div>
<!-- Cod Box Copy end --></code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Latest Orders</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-status table-responsive latest-order-table">
                                        <table class="table table-bordernone">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">Order Total</th>
                                                    <th scope="col">Payment Method</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="digits">Rs120.00</td>
                                                    <td class="font-danger">Bank Transfers</td>
                                                    <td class="digits">On Way</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td class="digits">Rs90.00</td>
                                                    <td class="font-secondary">Ewallets</td>
                                                    <td class="digits">Delivered</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td class="digits">Rs240.00</td>
                                                    <td class="font-warning">Cash</td>
                                                    <td class="digits">Delivered</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td class="digits">Rs120.00</td>
                                                    <td class="font-primary">Direct Deposit</td>
                                                    <td class="digits">Rs6523</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td class="digits">Rs50.00</td>
                                                    <td class="font-primary">Bank Transfers</td>
                                                    <td class="digits">Delivered</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <a href="order.html" class="btn btn-primary mt-4">View All Orders</a>
                                    </div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head1" title="" data-original-title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                                        <pre class=" language-html"><code class=" language-html" id="example-head1">
<div class="user-status table-responsive latest-order-table">
    <table class="table table-bordernone">
        <thead>
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Order Total</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="digits">Rs120.00</td>
                <td class="font-secondary">Bank Transfers</td>
                <td class="digits">Delivered</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="digits">Rs90.00</td>
                <td class="font-secondary">Ewallets</td>
                <td class="digits">Delivered</td>
            </tr>
            <tr>
                <td>3</td>
                <td class="digits">Rs240.00</td>
                <td class="font-secondary">Cash</td>
                <td class="digits">Delivered</td>
            </tr>
            <tr>
                <td>4</td>
                <td class="digits">Rs120.00</td>
                <td class="font-primary">Direct Deposit</td>
                <td class="digits">Delivered</td>
            </tr>
            <tr>
                <td>5</td>
                <td class="digits">Rs50.00</td>
                <td class="font-primary">Bank Transfers</td>
                <td class="digits">Delivered</td>
            </tr>
        </tbody>
    </table>
</div>
                                    </code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 xl-50">
                            <div class="card order-graph sales-carousel">
                                <div class="card-header b-header">
                                    <h6>Total Sales</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="small-chartjs">
                                                <div class="flot-chart-placeholder" id="simple-line-chart-sparkline-3">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="value-graph">
                                                <h3>42% <span><i class="fa fa-angle-up font-primary"></i></span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Sales Last Month</span>
                                            <h2 class="mb-0">9054</h2>
                                            <p>0.25% <span><i class="fa fa-angle-up"></i></span></p>
                                        </div>

                                        <div class="bg-primary">
                                            <div class="small-box">
                                                <i data-feather="briefcase"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sales-contain">
                                        <h5 class="f-w-600">Gross sales of August</h5>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 xl-50">
                            <div class="card order-graph sales-carousel">
                                <div class="card-header b-header">
                                    <h6>Total purchase</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="small-chartjs">
                                                <div class="flot-chart-placeholder" id="simple-line-chart-sparkline">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="value-graph">
                                                <h3>20% <span><i class="fa fa-angle-up font-secondary"></i></span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Monthly purchase</span>
                                            <h2 class="mb-0">2154</h2>
                                            <p>0.13% <span><i class="fa fa-angle-up"></i></span></p>
                                        </div>
                                        <div class="bg-secondary">
                                            <div class="small-box">
                                                <i data-feather="credit-card"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sales-contain">
                                        <h5 class="f-w-600">Avg Gross purchase</h5>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 xl-50">
                            <div class="card order-graph sales-carousel">
                                <div class="card-header b-header">
                                    <h6>Total cash transaction</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="small-chartjs">
                                                <div class="flot-chart-placeholder" id="simple-line-chart-sparkline-2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="value-graph">
                                                <h3>28% <span><i class="fa fa-angle-up font-warning"></i></span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Cash on hand</span>
                                            <h2 class="mb-0">4672</h2>
                                            <p>0.8% <span><i class="fa fa-angle-up"></i></span></p>
                                        </div>
                                        <div class="bg-warning">
                                            <div class="small-box">
                                                <i data-feather="shopping-cart"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sales-contain">
                                        <h5 class="f-w-600">Details about cash</h5>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 xl-50">
                            <div class="card order-graph sales-carousel">
                                <div class="card-header b-header">
                                    <h6>Daily Deposits</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="small-chartjs">
                                                <div class="flot-chart-placeholder" id="simple-line-chart-sparkline-1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="value-graph">
                                                <h3>75% <span><i class="fa fa-angle-up font-danger"></i></span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Security Deposits</span>
                                            <h2 class="mb-0">0782</h2>
                                            <p>0.25% <span><i class="fa fa-angle-up"></i></span></p>
                                        </div>
                                        <div class="bg-danger">
                                            <div class="small-box">
                                                <i data-feather="calendar"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sales-contain">
                                        <h5 class="f-w-600">Gross sales of June</h5>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Buy / Sell</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body sell-graph">
                                    <canvas id="myGraph"></canvas>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head3" title="" data-original-title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                                        <pre class=" language-html"><code class=" language-html" id="example-head3"><div class="card-body sell-graph">
   <canvas id="myGraph"></canvas>
</div></code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card height-equal">
                                <div class="card-header">
                                    <h5>Goods return</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-status table-responsive products-table">
                                        <table class="table table-bordernone mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Details</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Simply dummy text of the printing</td>
                                                    <td class="digits">1</td>
                                                    <td class="font-primary">Pending</td>
                                                    <td class="digits">Rs6523</td>
                                                </tr>
                                                <tr>
                                                    <td>Long established</td>
                                                    <td class="digits">5</td>
                                                    <td class="font-secondary">Cancle</td>
                                                    <td class="digits">Rs6523</td>
                                                </tr>
                                                <tr>
                                                    <td>sometimes by accident</td>
                                                    <td class="digits">10</td>
                                                    <td class="font-secondary">Cancle</td>
                                                    <td class="digits">Rs6523</td>
                                                </tr>
                                                <tr>
                                                    <td>Classical Latin literature</td>
                                                    <td class="digits">9</td>
                                                    <td class="font-primary">Return</td>
                                                    <td class="digits">Rs6523</td>
                                                </tr>
                                                <tr>
                                                    <td>keep the site on the Internet</td>
                                                    <td class="digits">8</td>
                                                    <td class="font-primary">Pending</td>
                                                    <td class="digits">Rs6523</td>
                                                </tr>
                                                <tr>
                                                    <td>Molestiae consequatur</td>
                                                    <td class="digits">3</td>
                                                    <td class="font-secondary">Cancle</td>
                                                    <td class="digits">Rs6523</td>
                                                </tr>
                                                <tr>
                                                    <td>Pain can procure</td>
                                                    <td class="digits">8</td>
                                                    <td class="font-primary">Return</td>
                                                    <td class="digits">Rs6523</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head4" title="" data-original-title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                                        <pre class=" language-html"><code class=" language-html" id="example-head4">
<div class="user-status table-responsive products-table">
    <table class="table table-bordernone mb-0">
        <thead>
            <tr>
                <th scope="col">Details</th>
                <th scope="col">Quantity</th>
                <th scope="col">Status</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Simply dummy text of the printing</td>
                <td class="digits">1</td>
                <td class="font-primary">Pending</td>
                <td class="digits">Rs6523</td>
            </tr>
            <tr>
                <td>Long established</td>
                <td class="digits">5</td>
                <td class="font-secondary">Cancle</td>
                <td class="digits">Rs6523</td>
            </tr>
            <tr>
                <td>sometimes by accident</td>
                <td class="digits">10</td>
                <td class="font-secondary">Cancle</td>
                <td class="digits">Rs6523</td>
            </tr>
            <tr>
                <td>Classical Latin literature</td>
                <td class="digits">9</td>
                <td class="font-primary">Return</td>
                <td class="digits">Rs6523</td>
            </tr>
            <tr>
                <td>keep the site on the Internet</td>
                <td class="digits">8</td>
                <td class="font-primary">Pending</td>
                <td class="digits">Rs6523</td>
            </tr>
            <tr>
                <td>Molestiae consequatur</td>
                <td class="digits">3</td>
                <td class="font-secondary">Cancle</td>
                <td class="digits">Rs6523</td>
            </tr>
            <tr>
                <td>Pain can procure</td>
                <td class="digits">8</td>
                <td class="font-primary">Return</td>
                <td class="digits">Rs6523</td>
            </tr>
        </tbody>
    </table>
</div>
                                    </code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card height-equal">
                                <div class="card-header">
                                    <h5>Empolyee Status</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-status table-responsive products-table">
                                        <table class="table table-bordernone mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Designation</th>
                                                    <th scope="col">Skill Level</th>
                                                    <th scope="col">Experience</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 blur-up lazyloaded" src="{{url('/')}}/backend/images/user2.jpg" alt="" data-original-title="" title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">John Deo <span class="text-muted digits">(14+
                                                                        Online)</span></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Designer</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">2 Year</td>
                                                </tr>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 blur-up lazyloaded" src="{{url('/')}}/backend/images/user1.jpg" alt="" data-original-title="" title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">Holio Mako <span class="text-muted digits">(250+ Online)</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Developer</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">3 Year</td>
                                                </tr>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 blur-up lazyloaded" src="{{url('/')}}/backend/images/user3.jpg" alt="" data-original-title="" title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">Mohsib lara<span class="text-muted digits">(99+ Online)</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Tester</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">5 Month</td>
                                                </tr>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 blur-up lazyloaded" src="{{url('/')}}/backend/images/user.jpg" alt="" data-original-title="" title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">Hileri Soli <span class="text-muted digits">(150+ Online)</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Designer</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">3 Month</td>
                                                </tr>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 blur-up lazyloaded" src="{{url('/')}}/backend/images/designer.jpg" alt="" data-original-title="" title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">Pusiz bia <span class="text-muted digits">(14+ Online)</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Designer</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">5 Year</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head5" title="" data-original-title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                                        <pre class=" language-html"><code class=" language-html" id="example-head5">
<div class="user-status table-responsive products-table">
    <table class="table table-bordernone mb-0">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Skill Level</th>
                <th scope="col">Experience</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td class="bd-t-none u-s-tb">
                        <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="{{url('/')}}/backend/images/user2.jpg" alt="" data-original-title="" title="">
                        <div class="d-inline-block">
                        <h6>John Deo <span class="text-muted digits">(14+ Online)</span></h6>
                        </div>
                        </div>
                    </td>
                    <td>Designer</td>
                    <td>
                        <div class="progress-showcase">
                        <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </div>
                    </td>
                    <td class="digits">2 Year</td>
                </tr>
            <tr>
                <td class="bd-t-none u-s-tb">
                    <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="{{url('/')}}/backend/images/user1.jpg" alt="" data-original-title="" title="">
                    <div class="d-inline-block">
                    <h6>Holio Mako <span class="text-muted digits">(250+ Online)</span></h6>
                    </div>
                    </div>
                </td>
                <td>Developer</td>
                <td>
                    <div class="progress-showcase">
                    <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </td>
                <td class="digits">3 Year</td>
            </tr>
            <tr>
                <td class="bd-t-none u-s-tb">
                    <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="{{url('/')}}/backend/images/user3.jpg" alt="" data-original-title="" title="">
                    <div class="d-inline-block">
                    <h6>Mohsib lara<span class="text-muted digits">(99+ Online)</span></h6>
                    </div>
                    </div>
                </td>
                <td>Tester</td>
                <td>
                    <div class="progress-showcase">
                    <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </td>
                <td class="digits">5 Month</td>
            </tr>
            <tr>
                <td class="bd-t-none u-s-tb">
                    <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="{{url('/')}}/backend/images/user.jpg" alt="" data-original-title="" title="">
                    <div class="d-inline-block">
                    <h6>Hileri Soli <span class="text-muted digits">(150+ Online)</span></h6>
                    </div>
                    </div>
                </td>
                <td>Designer</td>
                <td>
                    <div class="progress-showcase">
                    <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </td>
                <td class="digits">3 Month</td>
            </tr>
            <tr>
                <td class="bd-t-none u-s-tb">
                    <div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="{{url('/')}}/backend/images/designer.jpg" alt="" data-original-title="" title="">
                    <div class="d-inline-block">
                    <h6>Pusiz bia <span class="text-muted digits">(14+ Online)</span></h6>
                    </div>
                    </div>
                </td>
                <td>Designer</td>
                <td>
                    <div class="progress-showcase">
                    <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </td>
                <td class="digits">5 Year</td>
            </tr>
        </tbody>
    </table>
</div>
                                    </code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Sales Status</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 xl-50">
                                            <div class="order-graph">
                                                <h6>Orders By Location</h6>
                                                <div class="chart-block chart-vertical-center">
                                                    <canvas id="myDoughnutGraph"></canvas>
                                                </div>
                                                <div class="order-graph-bottom">
                                                    <div class="media">
                                                        <div class="order-color-primary"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Saint Lucia <span class="pull-right">Rs157</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-color-secondary"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Kenya <span class="pull-right">Rs347</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-color-danger"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Liberia<span class="pull-right">Rs468</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-color-warning"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Christmas Island<span class="pull-right">Rs742</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-color-success"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Saint Helena <span class="pull-right">Rs647</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 xl-50">
                                            <div class="order-graph sm-order-space">
                                                <h6>Sales By Location</h6>
                                                <div class="peity-chart-dashboard text-center">
                                                    <span class="pie-colours-1">4,7,6,5</span>
                                                </div>
                                                <div class="order-graph-bottom sales-location">
                                                    <div class="media">
                                                        <div class="order-shape-primary"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">Germany <span class="pull-right">25%</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-shape-secondary"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">Brasil <span class="pull-right">10%</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-shape-danger"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">United Kingdom<span class="pull-right">34%</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-shape-warning"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">Australia<span class="pull-right">5%</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-shape-success"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">Canada <span class="pull-right">25%</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 xl-100">
                                            <div class="order-graph xl-space">
                                                <h6>Revenue for last month</h6>
                                                <div class="ct-4 flot-chart-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head2" title="" data-original-title="Copy">
                                            <i class="icofont icofont-copy-alt"></i>
                                        </button>
                                        <pre class=" language-html">                                            <code class=" language-html" id="example-head2"><div class="row">
   <div class="col-xl-3 col-sm-6 xl-50">
      <div class="order-graph">
         <h6>Orders By Location</h6>
         <div class="chart-block chart-vertical-center">
            <canvas id="myDoughnutGraph"></canvas>
         </div>
         <div class="order-graph-bottom">
            <div class="media">
               <div class="order-color-primary"></div>
               <div class="media-body">
                  <h6 class="mb-0">Saint Lucia <span class="pull-right">Rs157</span></h6>
               </div>
            </div>
            <div class="media">
               <div class="order-color-secondary"></div>
               <div class="media-body">
                  <h6 class="mb-0">Kenya <span class="pull-right">Rs347</span></h6>
               </div>
            </div>
            <div class="media">
               <div class="order-color-danger"></div>
               <div class="media-body">
                  <h6 class="mb-0">Liberia<span class="pull-right">Rs468</span></h6>
               </div>
            </div>
            <div class="media">
               <div class="order-color-warning"></div>
               <div class="media-body">
                  <h6 class="mb-0">Christmas Island<span class="pull-right">Rs742</span></h6>
               </div>
            </div>
            <div class="media">
               <div class="order-color-success"></div>
               <div class="media-body">
                  <h6 class="mb-0">Saint Helena <span class="pull-right">Rs647</span></h6>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-3 col-sm-6 xl-50">
      <div class="order-graph sm-order-space">
         <h6>Sales By Location</h6>
         <div class="peity-chart-dashboard text-center">
            <span class="pie-colours-1">4,7,6,5</span>
         </div>
         <div class="order-graph-bottom sales-location">
            <div class="media">
               <div class="order-shape-primary"></div>
                  <div class="media-body">
                     <h6 class="mb-0 me-0">Germany <span class="pull-right">25%</span></h6>
                  </div>
            </div>
            <div class="media">
               <div class="order-shape-secondary"></div>
               <div class="media-body">
                  <h6 class="mb-0 me-0">Brasil <span class="pull-right">10%</span></h6>
               </div>
            </div>
            <div class="media">
               <div class="order-shape-danger"></div>
                  <div class="media-body">
                     <h6 class="mb-0 me-0">United Kingdom<span class="pull-right">34%</span></h6>
                  </div>
            </div>
            <div class="media">
               <div class="order-shape-warning"></div>
               <div class="media-body">
                  <h6 class="mb-0 me-0">Australia<span class="pull-right">5%</span></h6>
               </div>
            </div>
            <div class="media">
               <div class="order-shape-success"></div>
               <div class="media-body">
                  <h6 class="mb-0 me-0">Canada <span class="pull-right">25%</span></h6>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-6 xl-100">
      <div class="order-graph xl-space">
         <h6>Revenue for last month</h6>
         <div class="ct-4 flot-chart-container"></div>
      </div>
   </div>
</div></code>
</pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>

           @endsection