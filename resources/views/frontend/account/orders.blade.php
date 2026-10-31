@extends('frontend.layout.app')
@section('page-css')
<style>
.hom-dashboard{--dash-ink:#171344;--dash-pink:#f522a2;--dash-muted:#77829a;min-height:62vh;padding:30px 0 72px;background:#fafafa;color:var(--dash-ink)}
.hom-dashboard-grid{display:grid;grid-template-columns:300px minmax(0,1fr);gap:24px;align-items:start}
.hom-dash-panel{background:#fff;border:1px solid #f0f0f2;border-radius:16px;box-shadow:0 12px 34px rgba(26,19,68,.045)}
.hom-dash-sidebar{padding:24px 18px;min-height:100%}
.hom-dash-person{position:relative;text-align:center;padding:4px 8px 24px;border-bottom:1px solid #eff0f3}
.hom-dash-avatar{display:grid;place-items:center;width:104px;height:104px;margin:0 auto 15px;border:5px solid #fff;border-radius:50%;outline:4px solid #f522a2;background:linear-gradient(145deg,#fce7f4,#eee9ff);color:#692254;font:38px Georgia,serif;text-transform:uppercase}
.hom-dash-person h2{margin:0 0 5px;color:var(--dash-ink);font:700 20px Arial,sans-serif}
.hom-dash-person p{margin:0;color:var(--dash-muted);font-size:14px;overflow-wrap:anywhere}
.hom-dash-person small{display:block;margin-top:5px;color:#8c95a7;font-size:12px}
.hom-dash-camera{position:absolute;top:81px;left:calc(50% + 27px);display:grid;place-items:center;width:35px;height:35px;border:3px solid #fff;border-radius:50%;background:var(--dash-pink);color:#fff;text-decoration:none;font-size:14px}
.hom-dash-nav{display:grid;gap:7px;padding-top:20px}
.hom-dash-nav a,.hom-dash-nav button{display:flex;align-items:center;gap:13px;width:100%;min-height:48px;padding:11px 13px;border:0;border-radius:9px;background:transparent;color:var(--dash-ink);text-align:left;text-decoration:none;font:600 14px Arial,sans-serif;cursor:pointer;transition:background .18s,color .18s}
.hom-dash-nav a .hom-dash-nav-icon,.hom-dash-nav button .hom-dash-nav-icon{display:grid;place-items:center;width:21px;color:var(--dash-pink);font-size:18px}
.hom-dash-nav a.active{background:var(--dash-pink);color:#fff;box-shadow:0 8px 18px #f522a235}
.hom-dash-nav a.active .hom-dash-nav-icon{color:#fff}
.hom-dash-nav a:hover,.hom-dash-nav button:hover{background:#fff0f8;color:#b30e70}
.hom-dash-nav a.active:hover{background:#e91b94;color:#fff}
.hom-dash-nav b{display:grid;place-items:center;min-width:30px;height:27px;margin-left:auto;padding:0 7px;border-radius:20px;background:#ffe2e2;color:#f04f59;font-size:12px}
.hom-dash-nav form{margin:0}
.hom-dash-content{display:grid;gap:22px;min-width:0}
.hom-dash-summary,.hom-dash-orders{padding:24px 26px}
.hom-dash-title{display:flex;align-items:center;justify-content:space-between;gap:18px;padding-bottom:17px;margin-bottom:20px;border-bottom:1px solid #eef0f3}
.hom-dash-title h1,.hom-dash-title h2{margin:0;color:var(--dash-ink);font:700 25px Arial,sans-serif}
.hom-dash-title p{margin:6px 0 0;color:var(--dash-muted);font-size:13px}
.hom-dash-action{display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:0 18px;border-radius:9px;background:var(--dash-pink);color:#fff;text-decoration:none;font-size:13px;font-weight:700;white-space:nowrap;box-shadow:0 7px 16px #f522a22b}
.hom-dash-action:hover{background:#df168b;color:#fff}
.hom-dash-cards{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
.hom-dash-stat{display:flex;align-items:center;justify-content:space-between;gap:12px;min-height:142px;padding:22px 20px;border-radius:13px;background:#f8f2ff;color:#a24de9}
.hom-dash-stat:nth-child(2){background:#f0f8f3;color:#0bb36b}
.hom-dash-stat:nth-child(3){background:#fff2f3;color:#f25158}
.hom-dash-stat strong{display:block;font-size:34px;line-height:1.1;font-weight:750;letter-spacing:-.04em}
.hom-dash-stat span{display:block;margin-top:9px;font-size:14px;font-weight:600}
.hom-dash-stat-icon{display:grid;place-items:center;flex:0 0 76px;width:76px;height:76px;border-radius:50%;background:#a24de9;color:#fff;font-size:28px}
.hom-dash-stat:nth-child(2) .hom-dash-stat-icon{background:#0bb36b}
.hom-dash-stat:nth-child(3) .hom-dash-stat-icon{background:#f25158}
.hom-dash-stat-icon span{display:block;margin:0;color:#fff;font-size:31px;line-height:1}
.hom-dash-table-wrap{overflow-x:auto}
.hom-dash-table{width:100%;min-width:690px;border-collapse:separate;border-spacing:0 9px}
.hom-dash-table th{padding:9px 12px;color:#7b859b;text-align:left;font-size:13px;font-weight:700;white-space:nowrap}
.hom-dash-table td{padding:16px 12px;background:#f8f8f9;color:#181818;font-size:14px;white-space:nowrap}
.hom-dash-table td:first-child{border-radius:10px 0 0 10px}
.hom-dash-table td:last-child{border-radius:0 10px 10px 0}
.hom-dash-table td a{color:#ed2aa2;font-weight:700;text-decoration:none}
.hom-order-pill{display:inline-block;padding:6px 11px;border-radius:30px;background:#f2e7ff;color:#a04de8;font-size:12px;font-weight:700;text-transform:capitalize}
.hom-order-pill.status-completed,.hom-order-pill.status-delivered{background:#dcf8e9;color:#08ad68}
.hom-order-pill.status-processing,.hom-order-pill.status-confirmed,.hom-order-pill.status-shipped{background:#def7fb;color:#00a9c8}
.hom-order-pill.status-cancelled,.hom-order-pill.status-payment-error{background:#ffe2e2;color:#e44c4c}
.hom-order-pill.status-placed,.hom-order-pill.status-payment-pending{background:#f2e7ff;color:#a04de8}
.hom-dash-eye{display:grid;place-items:center;width:39px;height:37px;margin:auto;border:1px solid #b8c0ca;border-radius:8px;background:#fff;color:#707b88!important;font-size:18px}
.hom-dash-eye:hover{border-color:var(--dash-pink);color:var(--dash-pink)!important}
.hom-dash-empty{padding:38px 20px;color:var(--dash-muted);text-align:center}
.hom-dash-empty h3{margin:0 0 8px;color:var(--dash-ink);font:23px Georgia,serif}
.hom-dash-empty p{margin:0 0 19px;font-size:14px}
.hom-dash-pagination{padding-top:12px}
.hom-dash-flash{padding:12px 16px;border:1px solid #c9ddce;border-radius:9px;background:#f2faf4;color:#285a38;font-size:13px}
@media(max-width:1050px){.hom-dashboard-grid{grid-template-columns:250px minmax(0,1fr)}.hom-dash-summary,.hom-dash-orders{padding:21px}.hom-dash-stat{min-height:125px;padding:17px}.hom-dash-stat-icon{flex-basis:60px;width:60px;height:60px}}
@media(max-width:760px){.hom-dashboard{padding:20px 0 48px}.hom-dashboard-grid{grid-template-columns:1fr;gap:16px}.hom-dash-sidebar{padding:16px}.hom-dash-person{display:flex;align-items:center;gap:15px;text-align:left;padding:5px 5px 16px}.hom-dash-avatar{width:66px;height:66px;margin:0;border-width:3px;outline-width:2px;font-size:25px;flex:0 0 auto}.hom-dash-camera{top:48px;left:55px;width:28px;height:28px;font-size:11px}.hom-dash-person h2{font-size:17px}.hom-dash-person p{font-size:12px}.hom-dash-nav{grid-template-columns:repeat(2,minmax(0,1fr));gap:5px;padding-top:13px}.hom-dash-nav a,.hom-dash-nav button{min-height:43px;padding:9px;font-size:12px}.hom-dash-nav a .hom-dash-nav-icon,.hom-dash-nav button .hom-dash-nav-icon{width:17px;font-size:15px}.hom-dash-summary,.hom-dash-orders{padding:17px 14px}.hom-dash-title{align-items:flex-start}.hom-dash-title h1,.hom-dash-title h2{font-size:20px}.hom-dash-title p{font-size:12px}.hom-dash-action{min-height:38px;padding:0 12px;font-size:11px}.hom-dash-cards{gap:9px}.hom-dash-stat{display:block;min-height:106px;padding:13px 11px}.hom-dash-stat strong{font-size:25px}.hom-dash-stat span{margin-top:7px;font-size:11px}.hom-dash-stat-icon{display:none}}
@media(max-width:420px){.hom-dash-cards{grid-template-columns:1fr}.hom-dash-stat{display:flex;align-items:center;min-height:75px;padding:14px 16px}.hom-dash-stat span{margin-top:4px}.hom-dash-stat-icon{display:grid;flex-basis:45px;width:45px;height:45px;font-size:20px}}
</style>
@endsection
@section('content')
<main class="main hom-dashboard"><div class="container">
    <div class="hom-dashboard-grid">
        <aside class="hom-dash-panel hom-dash-sidebar">
            <div class="hom-dash-person">
                <div class="hom-dash-avatar" aria-hidden="true">{{ collect(explode(' ', trim($customer->name)))->filter()->map(fn($part)=>mb_substr($part,0,1))->take(2)->implode('') }}</div>
                <a class="hom-dash-camera" href="{{ route('profile.show') }}" aria-label="Update profile photo">◎</a>
                <div><h2>{{ $customer->name }}</h2><p>{{ $customer->email }}</p><small>{{ $customer->phone ?: 'House Of Maithili customer' }}</small></div>
            </div>
            <nav class="hom-dash-nav" aria-label="Customer account">
                <a class="active" href="{{ route('account.orders.index') }}"><span class="hom-dash-nav-icon">◉</span>Dashboard</a>
                <a href="{{ route('profile.show') }}"><span class="hom-dash-nav-icon">♙</span>My Profile</a>
                <a href="{{ route('account.orders.index', ['all' => 1]) }}#orders"><span class="hom-dash-nav-icon">▢</span>My Order List <b>{{ str_pad((string)$summary['total'], 2, '0', STR_PAD_LEFT) }}</b></a>
                <a href="{{ route('shop.index') }}"><span class="hom-dash-nav-icon">♡</span>Continue shopping</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"><span class="hom-dash-nav-icon">⇥</span>Logout</button></form>
            </nav>
        </aside>
        <section class="hom-dash-content">
            @if(session('status'))<div class="hom-dash-flash" role="status">{{ session('status') }}</div>@endif
            <section class="hom-dash-panel hom-dash-summary">
                <div class="hom-dash-title"><div><h1>Summary</h1><p>Your purchases and order updates at a glance.</p></div></div>
                <div class="hom-dash-cards">
                    <div class="hom-dash-stat"><div><strong>{{ $summary['pending'] }}</strong><span>Open orders</span></div><div class="hom-dash-stat-icon" aria-hidden="true"><span>☷</span></div></div>
                    <div class="hom-dash-stat"><div><strong>{{ $summary['completed'] }}</strong><span>Completed orders</span></div><div class="hom-dash-stat-icon" aria-hidden="true"><span>▱</span></div></div>
                    <div class="hom-dash-stat"><div><strong>₹{{ number_format((float)$summary['spent'], 0) }}</strong><span>Paid with us</span></div><div class="hom-dash-stat-icon" aria-hidden="true"><span>▣</span></div></div>
                </div>
            </section>
            <section class="hom-dash-panel hom-dash-orders" id="orders">
                <div class="hom-dash-title"><div><h2>{{ $showAll ? 'My Order List' : 'Recent Orders' }}</h2><p>Order status, purchase date and invoice access.</p></div>@unless($showAll)<a class="hom-dash-action" href="{{ route('account.orders.index', ['all' => 1]) }}#orders">View All Orders</a>@else<a class="hom-dash-action" href="{{ route('account.orders.index') }}#orders">Recent orders</a>@endunless</div>
                @if($orders->count())
                    <div class="hom-dash-table-wrap"><table class="hom-dash-table"><thead><tr><th>#Order No</th><th>Purchased Date</th><th>Total</th><th>Status</th><th>Action</th></tr></thead><tbody>
                        @foreach($orders as $order)<tr><td><a href="{{ $invoiceUrls[$order->id] }}">#{{ $order->order_number }}</a></td><td>{{ $order->created_at->format('d M Y') }}</td><td>₹{{ number_format((float)$order->total,2) }}</td><td><span class="hom-order-pill status-{{ str_replace('_','-',$order->status) }}">{{ str_replace('_',' ',ucfirst($order->status)) }}</span></td><td><a class="hom-dash-eye" href="{{ $invoiceUrls[$order->id] }}" aria-label="View invoice for {{ $order->order_number }}">◎</a></td></tr>@endforeach
                    </tbody></table></div>
                    @if($showAll)<div class="hom-dash-pagination">{{ $orders->links() }}</div>@endif
                @else
                    <div class="hom-dash-empty"><h3>Your order history will appear here</h3><p>Orders placed with this email address will be saved to your profile.</p><a class="hom-dash-action" href="{{ route('shop.index') }}">Explore the collection</a></div>
                @endif
            </section>
        </section>
    </div>
</div></main>
@endsection
