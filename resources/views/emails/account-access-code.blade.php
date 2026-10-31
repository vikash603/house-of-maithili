<div style="margin:0;background:#f8f4ed;padding:32px 14px;color:#302a27;font-family:Arial,sans-serif">
    <div style="max-width:600px;margin:0 auto;background:#fffdfa;border:1px solid #e8dfd2;border-radius:14px;overflow:hidden">
        <div style="padding:24px 30px;background:#641d2b;color:#fff;text-align:center">
            <div style="font-family:Georgia,serif;font-size:23px;letter-spacing:.04em">House Of Maithili</div>
            <div style="margin-top:6px;color:#efd9b7;font-size:11px;letter-spacing:.18em;text-transform:uppercase">Crafted by women. Rooted in Bihar.</div>
        </div>
        <div style="padding:32px 30px">
            @if($order)
                <h1 style="margin:0 0 12px;color:#641d2b;font-family:Georgia,serif;font-size:26px;font-weight:400">Thank you for your order, {{ $order->customer_name }}</h1>
                <p style="margin:0 0 18px;line-height:1.65">Your order <strong>{{ $order->order_number }}</strong> has been received. Your order invoice is ready.</p>
                <p style="margin:0 0 22px"><a href="{{ $invoicePdfUrl }}" style="display:inline-block;padding:12px 18px;border-radius:7px;background:#641d2b;color:#fff;text-decoration:none;font-weight:bold">Download invoice PDF</a> <a href="{{ $invoiceUrl }}" style="color:#641d2b">View online</a></p>
                @if($code)<p style="margin:0 0 10px;line-height:1.6">@if($order->account_auto_created_at)Your customer profile was created after the order. Enter this one-time code on the confirmation page to verify your email; the order is already saved.@else Enter this one-time code on the confirmation page to sign in to your account and link the order.@endif</p>@endif
            @else
                <h1 style="margin:0 0 12px;color:#641d2b;font-family:Georgia,serif;font-size:26px;font-weight:400">Your sign-in code</h1>
                <p style="margin:0 0 18px;line-height:1.65">Use this one-time code to securely sign in to your House Of Maithili account.</p>
            @endif
            @if($code)<div style="margin:20px 0;padding:17px;border:1px solid #e6d6bf;border-radius:9px;background:#faf6ef;text-align:center;color:#641d2b;font-size:30px;font-weight:bold;letter-spacing:.28em">{{ $code }}</div>
            <p style="margin:0;color:#776e66;font-size:13px;line-height:1.6">This code expires in 10 minutes and can only be used once. House Of Maithili will never ask you to share it by phone.</p>@endif
            @if($order)
                <p style="margin:22px 0 0;color:#776e66;font-size:13px">Order total: <strong>₹{{ number_format((float) $order->total, 2) }}</strong> · {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Razorpay' }}</p>
            @endif
        </div>
    </div>
</div>
