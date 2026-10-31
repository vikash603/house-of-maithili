<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AccountOrderController extends Controller
{
    public function index(Request $request)
    {
        $customer = $request->user();
        $baseQuery = $customer->orders();
        $summary = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->whereIn('status', ['placed', 'payment_pending', 'payment_error', 'confirmed', 'processing', 'shipped'])->count(),
            'completed' => (clone $baseQuery)->whereIn('status', ['completed', 'delivered'])->count(),
            'spent' => (clone $baseQuery)->where('payment_status', 'paid')->sum('total'),
        ];
        $showAll = $request->boolean('all');
        $orders = $customer->orders()->withCount('items')->latest();
        $orders = $showAll ? $orders->paginate(10)->withQueryString() : $orders->limit(5)->get();
        $orderCollection = $showAll ? $orders->getCollection() : $orders;
        $invoiceUrls = $orderCollection->mapWithKeys(fn ($order) => [
            $order->id => URL::temporarySignedRoute('checkout.invoice', now()->addMonths(6), ['orderNumber' => $order->order_number]),
        ]);
        $invoicePdfUrls = $orderCollection->mapWithKeys(fn ($order) => [
            $order->id => URL::temporarySignedRoute('checkout.invoice.pdf', now()->addMonths(6), ['orderNumber' => $order->order_number]),
        ]);

        return view('frontend.account.orders', compact('customer', 'summary', 'orders', 'invoiceUrls', 'invoicePdfUrls', 'showAll'));
    }
}
