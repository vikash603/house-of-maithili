@extends('backend.layout.app')

@section('content')
@php
    $lifecycle = [
        ['Placed', (int) ($counts['placed'] ?? 0), 'placed', 'file-plus', 'new'],
        ['Pending approval', (int) ($counts['pending_approval'] ?? 0), 'pending_approval', 'clock', 'pending'],
        ['Confirmed', (int) ($counts['confirmed'] ?? 0), 'confirmed', 'check-circle', 'confirmed'],
        ['Rejected', (int) ($counts['rejected'] ?? 0), 'rejected', 'x-circle', 'cancelled'],
        ['Processing', (int) ($counts['processing'] ?? 0), 'processing', 'package', 'processing'],
        ['Packed', (int) ($counts['packed'] ?? 0), 'packed', 'archive', 'ready'],
        ['Ready to ship', (int) ($counts['ready_to_ship'] ?? 0), 'ready_to_ship', 'archive', 'ready'],
        ['Shipped', (int) ($counts['shipped'] ?? 0), 'shipped', 'truck', 'dispatched'],
        ['In transit', (int) ($counts['in_transit'] ?? 0), 'in_transit', 'map-pin', 'dispatched'],
        ['Out for delivery', (int) ($counts['out_for_delivery'] ?? 0), 'out_for_delivery', 'navigation', 'dispatched'],
        ['Delivered', (int) ($counts['delivered'] ?? 0), 'delivered', 'check', 'delivered'],
        ['Cancellation requested', (int) ($counts['cancellation_requested'] ?? 0), 'cancellation_requested', 'alert-circle', 'pending'],
        ['Cancelled', (int) ($counts['cancelled'] ?? 0), 'cancelled', 'x-circle', 'cancelled'],
        ['Return requested', (int) ($counts['return_requested'] ?? 0), 'return_requested', 'corner-up-left', 'returns'],
        ['Return approved', (int) ($counts['return_approved'] ?? 0), 'return_approved', 'check-circle', 'returns'],
        ['Return rejected', (int) ($counts['return_rejected'] ?? 0), 'return_rejected', 'x-circle', 'cancelled'],
        ['Returned', (int) ($counts['returned'] ?? 0), 'returned', 'corner-up-left', 'returned'],
        ['Refund initiated', (int) ($counts['refund_initiated'] ?? 0), 'refund_initiated', 'rotate-ccw', 'refunds'],
        ['Refunded', (int) ($counts['refunded'] ?? 0), 'refunded', 'check-circle', 'delivered'],
    ];
    $summaryCards = [
        ['Total orders', $metrics['total'], 'shopping-bag', 'orders'],
        ['Paid revenue', '₹'.number_format((float) $metrics['sales'], 2), 'trending-up', 'revenue'],
        ['Pending orders', $metrics['pending'], 'clock', 'pending'],
        ['Confirmed', $metrics['confirmed'], 'check-circle', 'confirmed'],
        ['Processing', $metrics['processing'], 'package', 'processing'],
        ['Ready to ship', $metrics['ready_to_ship'], 'archive', 'ready'],
        ['Dispatched', $metrics['dispatched'], 'truck', 'dispatched'],
        ['Delivered', $metrics['delivered'], 'check', 'delivered'],
        ['Cancelled', $metrics['cancelled'], 'x-circle', 'cancelled'],
        ['Return requests', $metrics['returns'], 'corner-up-left', 'returns'],
        ['Refund pending', $metrics['refunds'], 'rotate-ccw', 'refunds'],
        ['Average order value', '₹'.number_format((float) $metrics['aov'], 2), 'bar-chart-2', 'average'],
        ['Customers in period', $metrics['customers'], 'users', 'customers'],
    ];
    $peakOrders = max((int) $daily->max('orders'), 1);
@endphp

<main class="page-body admin-order-dashboard">
    <div class="container-fluid catalog-page">
        <header class="catalog-page-header admin-dashboard-heading">
            <div>
                <nav class="admin-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('admin.orders.dashboard') }}">Admin</a><span>/</span><span>Orders</span></nav>
                <span class="catalog-eyebrow">ORDERS &amp; FULFILMENT</span>
                <h1>Order dashboard</h1>
                <p>Live sales and order activity from your store.</p>
            </div>
            <div class="catalog-header-actions">
                <a class="btn btn-outline-primary" href="{{ route('admin.orders.export', ['from' => $start->format('Y-m-d'), 'to' => $end->format('Y-m-d')]) }}"><i data-feather="download"></i> Export report</a>
                <a class="btn btn-primary" href="{{ route('admin.orders.index') }}"><i data-feather="list"></i> All orders</a>
            </div>
        </header>

        <form method="GET" action="{{ route('admin.orders.dashboard') }}" class="catalog-card admin-date-filter">
            <div class="admin-filter-intro"><span class="admin-filter-icon"><i data-feather="calendar"></i></span><span><strong>Reporting period</strong><small>Choose a date range for your order metrics.</small></span></div>
            <div class="admin-filter-fields">
                <label><span>From</span><input class="form-control" type="date" name="from" value="{{ $start->format('Y-m-d') }}" required></label>
                <label><span>To</span><input class="form-control" type="date" name="to" value="{{ $end->format('Y-m-d') }}" required></label>
                <button class="btn btn-primary" type="submit">Apply range</button>
                <div class="admin-date-presets" aria-label="Quick date ranges">
                    <a href="{{ route('admin.orders.dashboard') }}">30 days</a>
                    <a href="{{ route('admin.orders.dashboard', ['from' => now()->subDays(6)->toDateString(), 'to' => now()->toDateString()]) }}">7 days</a>
                    <a href="{{ route('admin.orders.dashboard', ['from' => now()->subDays(89)->toDateString(), 'to' => now()->toDateString()]) }}">90 days</a>
                </div>
            </div>
        </form>

        <section aria-labelledby="order-summary-title" class="admin-summary-section">
            <div class="admin-section-heading"><div><span class="admin-section-kicker">AT A GLANCE</span><h2 id="order-summary-title">Store performance</h2></div><span class="admin-period-label">{{ $start->format('d M Y') }} – {{ $end->format('d M Y') }}</span></div>
            <div class="admin-summary-grid">
                @foreach($summaryCards as [$label, $value, $icon, $tone])
                    <article class="admin-summary-card tone-{{ $tone }}">
                        <span class="admin-summary-icon"><i data-feather="{{ $icon }}"></i></span>
                        <span class="admin-summary-label">{{ $label }}</span>
                        <strong class="admin-summary-value">{{ $value }}</strong>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="catalog-card admin-lifecycle-card" aria-labelledby="order-lifecycle-title">
            <div class="catalog-card-header"><div><span class="admin-section-kicker">FULFILMENT FLOW</span><h2 id="order-lifecycle-title">Order lifecycle</h2><p>Current counts mapped to the order statuses used by your store.</p></div><a href="{{ route('admin.orders.index') }}">Manage orders <i data-feather="arrow-right"></i></a></div>
            <div class="admin-lifecycle-grid">
                @foreach($lifecycle as [$label, $count, $status, $icon, $tone])
                    <a class="admin-lifecycle-step tone-{{ $tone }}" href="{{ route('admin.orders.index', ['status' => $status, 'from' => $start->toDateString(), 'to' => $end->toDateString()]) }}">
                        <span class="admin-lifecycle-icon"><i data-feather="{{ $icon }}"></i></span>
                        <span class="admin-lifecycle-copy"><small>{{ $label }}</small><strong>{{ number_format($count) }}</strong></span>
                    </a>
                @endforeach
            </div>
        </section>

        <div class="row admin-dashboard-row">
            <section class="col-xl-8" aria-labelledby="sales-overview-title">
                <div class="catalog-card admin-chart-card">
                    <div class="catalog-card-header"><div><span class="admin-section-kicker">SALES OVERVIEW</span><h2 id="sales-overview-title">Daily orders &amp; paid sales</h2><p>Daily activity for the selected reporting period.</p></div><span class="admin-chart-legend"><i></i> Orders</span></div>
                    <div class="catalog-card-body">
                        @if($daily->isNotEmpty())
                            <div class="admin-daily-chart" role="img" aria-label="Daily order counts. Hover or focus each bar for the date and paid sales total.">
                                @foreach($daily as $day)
                                    @php($barHeight = max(5, round($day->orders / $peakOrders * 100)))
                                    <div class="admin-chart-column" title="{{ \Carbon\Carbon::parse($day->day)->format('d M Y') }} · {{ $day->orders }} orders · ₹{{ number_format((float) $day->sales, 2) }}">
                                        <span class="admin-chart-value">{{ $day->orders }}</span>
                                        <span class="admin-chart-bar" style="--bar-height: {{ $barHeight }}%"></span>
                                        <small>{{ \Carbon\Carbon::parse($day->day)->format('d M') }}</small>
                                    </div>
                                @endforeach
                            </div>
                            <div class="table-responsive admin-chart-table-wrap">
                                <table class="table admin-data-table mb-0"><thead><tr><th>Date</th><th>Orders</th><th>Paid sales</th></tr></thead><tbody>
                                    @foreach($daily as $day)<tr><td>{{ \Carbon\Carbon::parse($day->day)->format('d M Y') }}</td><td>{{ number_format($day->orders) }}</td><td>₹{{ number_format((float) $day->sales, 2) }}</td></tr>@endforeach
                                </tbody></table>
                            </div>
                        @else
                            <div class="admin-empty-state"><span><i data-feather="bar-chart-2"></i></span><strong>No sales activity in this period</strong><p>Orders and paid sales will appear here when recorded.</p></div>
                        @endif
                    </div>
                </div>
            </section>
            <div class="col-xl-4 admin-dashboard-breakdowns">
                <section class="catalog-card admin-breakdown-card" aria-labelledby="order-source-title">
                    <div class="catalog-card-header"><div><span class="admin-section-kicker">ACQUISITION</span><h2 id="order-source-title">Order sources</h2></div></div>
                    <div class="catalog-card-body">@forelse($sources as $source)<div class="admin-breakdown-row"><span>{{ $source->label }}</span><strong>{{ number_format($source->aggregate) }}</strong></div>@empty<div class="admin-inline-empty">No order-source attribution recorded.</div>@endforelse</div>
                </section>
                <section class="catalog-card admin-breakdown-card" aria-labelledby="payment-methods-title">
                    <div class="catalog-card-header"><div><span class="admin-section-kicker">COLLECTION</span><h2 id="payment-methods-title">Payment methods</h2></div></div>
                    <div class="catalog-card-body">@forelse($payments as $payment)<div class="admin-breakdown-row"><span>{{ $payment->label ? strtoupper($payment->label) : 'Not recorded' }}</span><strong>{{ number_format($payment->aggregate) }}</strong></div>@empty<div class="admin-inline-empty">No payment activity in this period.</div>@endforelse</div>
                </section>
            </div>
        </div>

        <div class="row admin-dashboard-row">
            <section class="col-xl-6" aria-labelledby="recent-orders-title">
                <div class="catalog-card admin-table-card">
                    <div class="catalog-card-header"><div><span class="admin-section-kicker">LATEST ACTIVITY</span><h2 id="recent-orders-title">Recent orders</h2></div><a href="{{ route('admin.orders.index', ['from' => $start->toDateString(), 'to' => $end->toDateString()]) }}">View all <i data-feather="arrow-right"></i></a></div>
                    <div class="table-responsive"><table class="table admin-data-table mb-0"><thead><tr><th>Order / customer</th><th>Total</th><th>Status</th></tr></thead><tbody>
                        @forelse($recent as $order)
                            <tr><td><a class="admin-order-reference" href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a><small class="d-block text-muted">{{ $order->customer_name }} · {{ $order->created_at->format('d M Y') }}</small></td><td class="admin-money">₹{{ number_format((float) $order->total, 2) }}</td><td><span class="admin-order-status status-{{ $order->status }}">{{ str($order->status)->replace('_', ' ')->title() }}</span></td></tr>
                        @empty<tr><td colspan="3"><div class="admin-inline-empty">No orders were recorded in this period.</div></td></tr>@endforelse
                    </tbody></table></div>
                </div>
            </section>
            <section class="col-xl-6" aria-labelledby="top-products-title">
                <div class="catalog-card admin-table-card">
                    <div class="catalog-card-header"><div><span class="admin-section-kicker">PRODUCT PERFORMANCE</span><h2 id="top-products-title">Top selling products</h2></div><a href="{{ route('products.index') }}">Products <i data-feather="arrow-right"></i></a></div>
                    <div class="catalog-card-body">@forelse($topProducts as $item)<div class="admin-product-row"><span class="admin-product-initial">{{ mb_substr($item->product_name ?: 'P', 0, 1) }}</span><span class="admin-product-name">{{ $item->product_name }}</span><strong>{{ number_format($item->quantity) }} sold</strong></div>@empty<div class="admin-empty-state admin-empty-compact"><span><i data-feather="package"></i></span><strong>No product sales in this period</strong><p>Product sales will appear here after orders are placed.</p></div>@endforelse</div>
                </div>
            </section>
        </div>

        <section id="order-inbox" class="catalog-card admin-inbox-card" aria-labelledby="order-inbox-title" tabindex="-1">
            <div class="catalog-card-header"><div><span class="admin-section-kicker">TEAM INBOX</span><h2 id="order-inbox-title">Order notifications</h2><p>Recent order updates for your account.</p></div>@if(($unreadNotificationCount ?? 0) > 0)<form method="POST" action="{{ route('admin.orders.notifications.read-all') }}">@csrf<button class="btn btn-outline-primary" type="submit">Mark all read</button></form>@endif</div>
            <div class="admin-inbox-list">
                @forelse(($notifications ?? collect()) as $notification)
                    <article class="admin-inbox-item {{ $notification->read_at ? '' : 'is-unread' }}">
                        <span class="admin-inbox-icon"><i data-feather="{{ $notification->read_at ? 'mail' : 'bell' }}"></i></span>
                        <div class="admin-inbox-copy"><strong>{{ $notification->data['event'] ?? 'Order update' }}</strong><p>{{ $notification->data['customer'] ?? 'Customer' }} · {{ $notification->data['order_number'] ?? 'Order details unavailable' }}</p><small>{{ $notification->created_at->diffForHumans() }}</small></div>
                        @if(!empty($notification->data['order_id']))<a class="admin-inbox-action" href="{{ $notification->read_at ? route('admin.orders.show', (int) $notification->data['order_id']) : route('admin.orders.notifications.read', $notification->id) }}">{{ $notification->read_at ? 'View order' : 'Open' }} <i data-feather="arrow-right"></i></a>@endif
                    </article>
                @empty
                    <div class="admin-empty-state admin-empty-compact"><span><i data-feather="inbox"></i></span><strong>Your inbox is clear</strong><p>Order notifications will show here when the team receives an update.</p></div>
                @endforelse
            </div>
        </section>

        <div class="row admin-dashboard-row">
            <section class="col-xl-6" aria-labelledby="recent-customers-title"><div class="catalog-card"><div class="catalog-card-header"><div><span class="admin-section-kicker">CUSTOMER ACTIVITY</span><h2 id="recent-customers-title">Recent customers</h2><p>Customers with orders in the selected period.</p></div></div><div class="catalog-card-body">@forelse($recentCustomers as $customer)<div class="admin-product-row"><span class="admin-product-initial">{{ mb_substr($customer->name ?: 'C', 0, 1) }}</span><span class="admin-product-name"><strong>{{ $customer->name }}</strong><small>{{ $customer->email }}</small></span><strong>{{ $customer->orders_count }} orders</strong></div>@empty<div class="admin-inline-empty">No registered customers placed orders in this period.</div>@endforelse</div></div></section>
            <section class="col-xl-6" aria-labelledby="low-stock-title"><div class="catalog-card"><div class="catalog-card-header"><div><span class="admin-section-kicker">INVENTORY WATCH</span><h2 id="low-stock-title">Low stock products</h2><p>Current inventory snapshot, independent of the order reporting period.</p></div><span class="admin-threshold-label">5 or fewer</span></div><div class="catalog-card-body">@forelse($lowStock as $product)<div class="admin-product-row"><span class="admin-product-initial"><i data-feather="package"></i></span><span class="admin-product-name">{{ $product->name }}</span><strong class="admin-stock-count">{{ $product->stock }} left</strong></div>@empty<div class="admin-inline-empty">No low-stock products.</div>@endforelse</div></div></section>
        </div>
    </div>
</main>
@endsection
