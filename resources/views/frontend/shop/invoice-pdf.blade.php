<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 34px 38px 42px; }
        body { color: #302a27; font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .top { width: 100%; border-bottom: 2px solid #6b2432; padding-bottom: 18px; }
        .brand { width: 56%; vertical-align: middle; }
        .brand img { width: 150px; height: auto; }
        .brand-note { color: #756b62; font-size: 9px; margin-top: 6px; }
        .meta { text-align: right; vertical-align: middle; }
        h1 { margin: 0 0 8px; color: #641d2b; font-family: DejaVu Serif, serif; font-size: 24px; font-weight: normal; }
        .meta p { margin: 4px 0; color: #756b62; }
        .parties { width: 100%; margin: 22px 0; }
        .parties td { width: 50%; vertical-align: top; line-height: 1.7; }
        .eyebrow { margin-bottom: 7px; color: #a0835d; font-size: 8px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; }
        .items { width: 100%; border-collapse: collapse; }
        .items thead { display: table-header-group; }
        .items th { padding: 9px 6px; border-bottom: 1px solid #dcd1c4; color: #7b6d5e; font-size: 8px; text-align: left; text-transform: uppercase; }
        .items td { padding: 10px 6px; border-bottom: 1px solid #eee8e0; vertical-align: top; }
        .items .number { text-align: right; white-space: nowrap; }
        .summary { width: 48%; margin: 18px 0 0 auto; border-collapse: collapse; }
        .summary td { padding: 6px 0; color: #6b6259; }
        .summary td:last-child { text-align: right; white-space: nowrap; }
        .summary .grand td { padding-top: 12px; border-top: 1px solid #dcd1c4; color: #302a27; font-size: 12px; font-weight: bold; }
        .foot { margin-top: 28px; padding-top: 12px; border-top: 1px solid #eee8e0; color: #80766d; font-size: 8px; line-height: 1.6; }
    </style>
</head>
<body>
    <table class="top"><tr>
        <td class="brand">@if($logoDataUri)<img src="{{ $logoDataUri }}" alt="House Of Maithili">@else<strong>{{ $seller['business_name'] }}</strong>@endif<div class="brand-note">{{ $seller['business_name'] }} · Crafted by women. Rooted in Bihar.<br>{{ $seller['support_email'] }} · {{ $seller['support_phone'] }}@if(filled($seller['business_address']))<br>{{ $seller['business_address'] }}@endif</div></td>
        <td class="meta"><h1>Order Invoice</h1><p><strong>Invoice:</strong> HOM-INV-{{ substr($order->order_number, 4) }}</p><p><strong>Order:</strong> {{ $order->order_number }}</p><p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p></td>
    </tr></table>
    <table class="parties"><tr>
        <td><div class="eyebrow">Deliver to</div><strong>{{ $order->customer_name }}</strong><br>{{ $order->phone }}<br>{{ $order->email }}<br>{{ $order->address }}<br>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</td>
        <td><div class="eyebrow">Payment</div>{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Razorpay' }}<br>Status: {{ $order->payment_status === 'paid' ? 'Paid' : 'Due on delivery' }}<br>Order status: {{ str_replace('_',' ',ucfirst($order->status)) }}</td>
    </tr></table>
    <table class="items"><thead><tr><th>Item</th><th>Options</th><th class="number">Qty</th><th class="number">Unit price</th><th class="number">Total</th></tr></thead><tbody>
        @foreach($order->items as $item)
            <tr><td><strong>{{ $item->product_name }}</strong>@if($item->sku)<br><span style="color:#80766d">SKU {{ $item->sku }}</span>@endif</td><td>{{ collect([$item->size,$item->color])->filter()->join(' · ') ?: '—' }}</td><td class="number">{{ $item->quantity }}</td><td class="number">₹{{ number_format((float)$item->unit_price,2) }}</td><td class="number">₹{{ number_format((float)$item->line_total,2) }}</td></tr>
        @endforeach
    </tbody></table>
    <table class="summary">
        <tr><td>Subtotal</td><td>₹{{ number_format((float)$order->subtotal,2) }}</td></tr>
        @if($order->discount_amount > 0)<tr><td>Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif</td><td>−₹{{ number_format((float)$order->discount_amount,2) }}</td></tr>@endif
        <tr><td>Delivery</td><td>Confirmed separately</td></tr>
        <tr class="grand"><td>Total before delivery</td><td>₹{{ number_format((float)$order->total,2) }}</td></tr>
    </table>
    <div class="foot">This document confirms your House Of Maithili order. Delivery charges are confirmed separately. Keep this invoice with your order number for customer support.</div>
</body>
</html>
