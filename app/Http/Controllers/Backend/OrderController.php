<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()->withCount('items')
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = trim($request->string('search')->toString());
                $query->where(fn ($query) => $query->where('order_number', 'like', '%'.$term.'%')->orWhere('customer_name', 'like', '%'.$term.'%')->orWhere('phone', 'like', '%'.$term.'%'));
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('payment_method'), fn ($query) => $query->where('payment_method', $request->string('payment_method')->toString()))
            ->latest()->paginate(20)->withQueryString();

        return view('backend.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('backend.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['placed','confirmed','processing','shipped','delivered','cancelled'])]]);
        if ($order->payment_method === 'razorpay' && $order->payment_status !== 'paid' && in_array($data['status'], ['confirmed','processing','shipped','delivered'], true)) {
            return back()->with('error', 'An online order must have a captured payment before it can be fulfilled.');
        }
        if ($order->payment_method === 'cod' && $order->payment_status !== 'paid' && $data['status'] === 'delivered') {
            return back()->with('error', 'Mark the Cash on Delivery amount as received before completing delivery.');
        }
        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Order status updated.');
    }

    public function markCodPaid(Order $order)
    {
        abort_unless($order->payment_method === 'cod', 404);
        if ($order->payment_status !== 'paid') $order->update(['payment_status' => 'paid', 'paid_at' => now()]);

        return back()->with('success', 'Cash on Delivery payment marked as received.');
    }
}
