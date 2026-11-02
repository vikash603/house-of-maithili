<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Services\OrderWorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AccountOrderController extends Controller
{
    public function index(Request $request)
    {
        $customer = $request->user();
        $baseQuery = $customer->orders();
        $summary = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->whereIn('status', ['placed','pending_approval','payment_pending','payment_error','confirmed','processing','packed','ready_to_ship','shipped','in_transit','out_for_delivery'])->count(),
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

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 404);
        $order->load(['items.product.category','events'=>fn($query)=>$query->where('is_internal',false),'returns']);
        return view('frontend.account.order-tracking', compact('order'));
    }

    public function requestCancellation(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        abort_unless($order->user_id === $request->user()->id, 404);
        $data = $request->validate(['reason'=>['required','string','max:2000']]);
        $workflow->transition($order,'cancellation_requested',$data['reason'],$request->user()->id,false);
        return back()->with('success','Your cancellation request was sent to our order team.');
    }

    public function requestReturn(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        abort_unless($order->user_id === $request->user()->id, 404);
        $data = $request->validate(['reason'=>['required','string','max:2000']]);
        if ($order->status !== 'delivered') throw ValidationException::withMessages(['reason'=>'A return request can only be raised for a delivered order.']);
        DB::transaction(function () use ($request,$order,$data,$workflow) {
            OrderReturn::create(['order_id'=>$order->id,'requested_by'=>$request->user()->id,'status'=>'requested','customer_reason'=>$data['reason']]);
            $workflow->transition($order,'return_requested',$data['reason'],$request->user()->id,false);
        });
        return back()->with('success','Your return request was sent to our order team.');
    }
}
