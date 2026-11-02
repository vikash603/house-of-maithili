<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderRefund;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public const STATUSES = ['placed','pending_approval','confirmed','rejected','processing','packed','ready_to_ship','shipped','in_transit','out_for_delivery','delivered','cancellation_requested','cancelled','return_requested','return_approved','return_rejected','returned','refund_initiated','refunded'];

    public function dashboard(Request $request)
    {
        [$start, $end] = $this->dateRange($request);
        $range = Order::query()->whereBetween('created_at', [$start, $end]);
        $counts = (clone $range)->selectRaw('status, COUNT(*) as aggregate')->groupBy('status')->pluck('aggregate', 'status');
        $metricRow = (clone $range)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status IN ('placed','pending_approval') THEN 1 ELSE 0 END) as pending")
            ->selectRaw("SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed")
            ->selectRaw("SUM(CASE WHEN status IN ('processing','packed') THEN 1 ELSE 0 END) as processing")
            ->selectRaw("SUM(CASE WHEN status = 'ready_to_ship' THEN 1 ELSE 0 END) as ready_to_ship")
            ->selectRaw("SUM(CASE WHEN status IN ('shipped','in_transit','out_for_delivery') THEN 1 ELSE 0 END) as dispatched")
            ->selectRaw("SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered")
            ->selectRaw("SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled")
            ->selectRaw("SUM(CASE WHEN status IN ('return_requested','return_approved','returned') THEN 1 ELSE 0 END) as returns")
            ->selectRaw("SUM(CASE WHEN refund_status IN ('pending','initiated') THEN 1 ELSE 0 END) as refunds")
            ->selectRaw("SUM(CASE WHEN payment_status = 'paid' THEN total ELSE 0 END) as sales")
            ->selectRaw("AVG(CASE WHEN payment_status = 'paid' THEN total ELSE NULL END) as aov")
            ->first();
        $metrics = array_map(static fn ($value) => $value ?? 0, $metricRow->getAttributes());
        $customersInRange = User::query()
            ->whereRaw('LOWER(TRIM(users.email)) <> ?', [User::AUTHORIZED_ADMIN_EMAIL])
            ->whereHas('orders', fn ($orders) => $orders->whereBetween('orders.created_at', [$start, $end]));
        $metrics['customers'] = (clone $customersInRange)->count();

        $recent = (clone $range)->withCount('items')->latest()->limit(8)->get();
        $sources = (clone $range)->selectRaw("COALESCE(NULLIF(source, ''), 'Unknown') as label, COUNT(*) as aggregate")->groupBy('label')->orderByDesc('aggregate')->get();
        $payments = (clone $range)->selectRaw('payment_method as label, COUNT(*) as aggregate')->groupBy('payment_method')->get();
        $topProducts = DB::table('order_items')->join('orders','orders.id','=','order_items.order_id')->whereBetween('orders.created_at',[$start,$end])->select('order_items.product_name',DB::raw('SUM(order_items.quantity) as quantity'))->groupBy('order_items.product_name')->orderByDesc('quantity')->limit(5)->get();
        $daily = (clone $range)->selectRaw('DATE(created_at) as day, COUNT(*) as orders, SUM(CASE WHEN payment_status = "paid" THEN total ELSE 0 END) as sales')->groupBy('day')->orderBy('day')->get();
        $periodOrderConstraint = fn ($orders) => $orders->whereBetween('orders.created_at', [$start, $end]);
        $recentCustomers = User::query()
            ->select(['users.id','users.name','users.email','users.created_at'])
            ->whereRaw('LOWER(TRIM(users.email)) <> ?', [User::AUTHORIZED_ADMIN_EMAIL])
            ->whereHas('orders', $periodOrderConstraint)
            ->withCount(['orders' => $periodOrderConstraint])
            ->withMax(['orders as period_latest_order_at' => $periodOrderConstraint], 'created_at')
            ->orderByDesc('period_latest_order_at')
            ->limit(5)
            ->get();
        $lowStock = Product::query()->where('status', true)->where('is_made_to_order', false)->where('stock', '<=', 5)->orderBy('stock')->limit(5)->get(['id','name','stock']);

        return view('backend.order.dashboard', compact('metrics','recent','sources','payments','topProducts','daily','counts','recentCustomers','lowStock','start','end'));
    }

    public function index(Request $request)
    {
        $this->validateFilters($request);
        $query = Order::query()->with('items')->withCount('items')->withSum('items as item_quantity', 'quantity');
        $query->when($request->filled('search'), function ($q) use ($request) {
            $term = trim($request->string('search')->toString());
            $q->where(fn ($sub) => $sub->where('order_number','like',"%{$term}%")->orWhere('customer_name','like',"%{$term}%")->orWhere('email','like',"%{$term}%")->orWhere('phone','like',"%{$term}%"));
        });
        $query->when($request->filled('status'), fn ($q) => $q->where('status',$request->string('status')->toString()));
        $query->when($request->filled('payment_status'), fn ($q) => $q->where('payment_status',$request->string('payment_status')->toString()));
        $query->when($request->filled('payment_method'), fn ($q) => $q->where('payment_method',$request->string('payment_method')->toString()));
        $query->when($request->filled('source'), fn ($q) => $q->where('source',$request->string('source')->toString()));
        $query->when($request->filled('return_status'), fn ($q) => $q->where('return_status',$request->string('return_status')->toString()));
        $query->when($request->filled('refund_status'), fn ($q) => $q->where('refund_status',$request->string('refund_status')->toString()));
        $query->when($request->filled('product'), fn ($q) => $q->whereHas('items', fn ($items) => $items->where('product_name','like','%'.trim($request->string('product')->toString()).'%')));
        $query->when($request->filled('courier'), fn ($q) => $q->where('courier_name','like','%'.trim($request->string('courier')->toString()).'%'));
        $query->when($request->filled('from'), fn ($q) => $q->whereDate('created_at','>=',$request->date('from')));
        $query->when($request->filled('to'), fn ($q) => $q->whereDate('created_at','<=',$request->date('to')));
        $query->when($request->filled('min_amount'), fn ($q) => $q->where('total','>=',(float)$request->input('min_amount')));
        $query->when($request->filled('max_amount'), fn ($q) => $q->where('total','<=',(float)$request->input('max_amount')));
        $sort = $request->string('sort','created_at')->toString();
        $direction = $request->string('direction','desc')->toString();
        $query->orderBy(in_array($sort,['created_at','total','status'],true) ? $sort : 'created_at', $direction === 'asc' ? 'asc' : 'desc');
        $orders = $query->paginate(25)->withQueryString();
        $sources = Order::whereNotNull('source')->distinct()->orderBy('source')->pluck('source');

        return view('backend.order.index', compact('orders','sources'));
    }

    public function export(Request $request)
    {
        $this->validateFilters($request);
        $orders = $this->filteredQuery($request)->withCount('items')->latest()->cursor();
        return response()->streamDownload(function () use ($orders) {
            $out = fopen('php://output','w');
            fputcsv($out,['Order ID','Date','Customer','Email','Phone','Items','Total','Payment Method','Payment Status','Order Status','Source','Courier','Tracking Number']);
            foreach ($orders as $o) fputcsv($out,[$o->order_number,$o->created_at,$o->customer_name,$o->email,$o->phone,$o->items_count,$o->total,$o->payment_method,$o->payment_status,$o->status,$o->source ?: 'Unknown',$o->courier_name,$o->tracking_number]);
            fclose($out);
        }, 'orders-'.now()->format('Ymd-His').'.csv', ['Content-Type'=>'text/csv; charset=UTF-8']);
    }

    public function show(Order $order)
    {
        $order->load(['items.product','events.actor','returns','refunds']);
        $nextStatuses = OrderWorkflowService::TRANSITIONS[$order->status] ?? [];
        return view('backend.order.show', compact('order','nextStatuses'));
    }

    public function updateStatus(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        $data = $request->validate(['status'=>['required',Rule::in(self::STATUSES)],'reason'=>['nullable','string','max:2000']]);
        $workflow->transition($order,$data['status'],$data['reason'] ?? null,$request->user()->id);
        if (in_array($data['status'],['return_approved','return_rejected','returned'],true)) {
            $order->returns()->latest()->first()?->update(['status'=>$data['status'],'reviewed_by'=>$request->user()->id,'reviewed_at'=>now(),'staff_notes'=>$data['reason'] ?? null]);
        }
        return back()->with('success','Order lifecycle status updated and recorded.');
    }

    public function updateShipping(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        $data = $request->validate(['courier_name'=>['nullable','string','max:120'],'tracking_number'=>['nullable','string','max:120'],'tracking_url'=>['nullable','url:http,https','max:500'],'expected_delivery_at'=>['nullable','date','after_or_equal:today']]);
        $order->update($data);
        $workflow->log($order,'shipping','Shipping details updated by staff.',$request->user()->id,true,array_filter($data));
        return back()->with('success','Shipping details saved. No shipment was marked dispatched.');
    }

    public function addNote(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        $data = $request->validate(['note'=>['required','string','max:4000']]);
        $workflow->log($order,'note',$data['note'],$request->user()->id,true);
        return back()->with('success','Internal note added.');
    }

    public function recordRefund(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        $data = $request->validate(['refund_id'=>['nullable','integer',Rule::exists('order_refunds','id')->where('order_id',$order->id)],'amount'=>['required','numeric','gt:0','lte:'.$order->total],'status'=>['required',Rule::in(['pending','initiated','completed','failed'])],'method'=>['nullable','string','max:40'],'transaction_reference'=>['nullable','string','max:190'],'notes'=>['required','string','max:2000']]);
        if (!in_array($order->payment_status,['paid','partially_refunded'],true)) return back()->withErrors(['amount'=>'A refund cannot be recorded for an order without a captured payment.'])->withInput();
        if (!in_array($order->status,['returned','refund_initiated','cancelled','refunded'],true)) return back()->withErrors(['status'=>'A refund can only be recorded after a return or cancellation has been approved.'])->withInput();
        if ($data['status'] === 'completed' && blank($data['transaction_reference'])) return back()->withErrors(['transaction_reference'=>'Enter the real refund reference before marking a refund complete.'])->withInput();
        DB::transaction(function () use ($order,$data,$request,$workflow) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            $previousPaymentStatus = $locked->payment_status;
            if (!in_array($locked->status,['returned','refund_initiated','cancelled','refunded'],true)) throw \Illuminate\Validation\ValidationException::withMessages(['status'=>'A refund can only be recorded after a return or cancellation has been approved.']);
            $existing = !empty($data['refund_id']) ? $locked->refunds()->whereKey($data['refund_id'])->firstOrFail() : null;
            if (filled($data['transaction_reference'] ?? null) && $locked->refunds()->where('transaction_reference',$data['transaction_reference'])->when($existing,fn($query)=>$query->where('id','!=',$existing->id))->exists()) {
                throw \Illuminate\Validation\ValidationException::withMessages(['transaction_reference'=>'This refund reference is already recorded for this order.']);
            }
            $alreadyRefunded = (float) $locked->refunds()->whereIn('status',['pending','initiated','completed'])->when($existing,fn($query)=>$query->where('id','!=',$existing->id))->sum('amount');
            // The payment flow captures the full order total; existing refund records reserve part of that captured amount.
            $capturedAmount = in_array($locked->payment_status,['paid','partially_refunded','refunded'],true) ? (float) $locked->total : 0.0;
            if ($alreadyRefunded + (float) $data['amount'] > $capturedAmount) throw \Illuminate\Validation\ValidationException::withMessages(['amount'=>'Recorded refunds cannot exceed the captured payment amount less previous refunds.']);
            unset($data['refund_id']);
            if ($existing) {
                $existing->update([...$data,'completed_at'=>$data['status'] === 'completed' ? now() : null]);
                $refund = $existing;
            } else {
                $refund = OrderRefund::create(['order_id'=>$order->id,'recorded_by'=>$request->user()->id,...$data,'completed_at'=>$data['status'] === 'completed' ? now() : null]);
            }
            $locked->update(['refund_status'=>$data['status']]);
            $workflow->log($locked,'refund','Refund record '.$data['status'].($data['status'] === 'completed' ? ' (reference provided).' : ' (manual record only).'),$request->user()->id,true,['refund_id'=>$refund->id]);
            if (in_array($data['status'],['pending','initiated'],true) && in_array($locked->status,['returned','cancelled'],true)) {
                $locked = $workflow->transition($locked,'refund_initiated','Refund is being handled outside the payment gateway.',$request->user()->id,true);
            }
            if ($data['status'] === 'completed') {
                if (in_array($locked->status,['returned','cancelled'],true)) $locked = $workflow->transition($locked,'refund_initiated','External refund action was reported by staff.',$request->user()->id,true);
                $refunded = (float) $locked->refunds()->where('status','completed')->sum('amount');
                if ($refunded >= $capturedAmount) {
                    if ($locked->status === 'refund_initiated') $locked = $workflow->transition($locked,'refunded','External refund completion recorded with reference.',$request->user()->id,true);
                    $locked->update(['payment_status'=>'refunded']);
                } else $locked->update(['payment_status'=>'partially_refunded','refund_status'=>'completed']);
            }
            if ($previousPaymentStatus !== $locked->payment_status) {
                $workflow->log($locked,'payment','Payment status changed from '.$previousPaymentStatus.' to '.$locked->payment_status.' after a manually recorded refund.',$request->user()->id,true,['refund_id'=>$refund->id]);
            }
        });
        return back()->with('success',$data['status'] === 'completed' ? 'Refund completion recorded with its reference.' : 'Refund workflow recorded; no gateway refund was submitted.');
    }

    public function markCodPaid(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        abort_unless($order->payment_method === 'cod',404);
        if ($order->status !== 'delivered') {
            return back()->withErrors(['payment_status'=>'COD collection can only be recorded after delivery is confirmed.']);
        }
        if ($order->payment_status !== 'paid') {
            DB::transaction(function () use ($order,$request,$workflow) {
                $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
                if ($locked->status !== 'delivered') throw \Illuminate\Validation\ValidationException::withMessages(['payment_status'=>'COD collection can only be recorded after delivery is confirmed.']);
                if ($locked->payment_status !== 'paid') {
                    $locked->update(['payment_status'=>'paid','paid_at'=>now()]);
                    $workflow->log($locked,'payment','Cash on Delivery amount received.',$request->user()->id,false);
                }
            });
        }
        return back()->with('success','Cash on Delivery collection recorded.');
    }

    public function markNotificationRead(Request $request, string $notification)
    {
        $item = $request->user()->notifications()->findOrFail($notification);
        $item->markAsRead();
        $orderId = $item->data['order_id'] ?? null;
        $order = $orderId ? Order::find($orderId) : null;
        return $order ? redirect()->route('admin.orders.show',$order) : back();
    }

    public function markAllNotificationsRead(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at'=>now()]);
        return back()->with('success','Notifications marked as read.');
    }

    private function filteredQuery(Request $request)
    {
        return Order::query()
            ->when($request->filled('search'),fn($q)=>$q->where(fn($s)=>$s->where('order_number','like','%'.$request->search.'%')->orWhere('customer_name','like','%'.$request->search.'%')->orWhere('email','like','%'.$request->search.'%')->orWhere('phone','like','%'.$request->search.'%')))
            ->when($request->filled('status'),fn($q)=>$q->where('status',$request->status))
            ->when($request->filled('payment_status'),fn($q)=>$q->where('payment_status',$request->payment_status))
            ->when($request->filled('payment_method'),fn($q)=>$q->where('payment_method',$request->payment_method))
            ->when($request->filled('source'),fn($q)=>$q->where('source',$request->source))
            ->when($request->filled('product'),fn($q)=>$q->whereHas('items',fn($items)=>$items->where('product_name','like','%'.trim($request->string('product')->toString()).'%')))
            ->when($request->filled('return_status'),fn($q)=>$q->where('return_status',$request->return_status))
            ->when($request->filled('refund_status'),fn($q)=>$q->where('refund_status',$request->refund_status))
            ->when($request->filled('courier'),fn($q)=>$q->where('courier_name','like','%'.$request->courier.'%'))
            ->when($request->filled('from'),fn($q)=>$q->whereDate('created_at','>=',$request->from))
            ->when($request->filled('to'),fn($q)=>$q->whereDate('created_at','<=',$request->to))
            ->when($request->filled('min_amount'),fn($q)=>$q->where('total','>=',(float)$request->input('min_amount')))
            ->when($request->filled('max_amount'),fn($q)=>$q->where('total','<=',(float)$request->input('max_amount')));
    }

    private function validateFilters(Request $request): void
    {
        $request->validate([
            'search'=>['nullable','string','max:160'],
            'status'=>['nullable',Rule::in(self::STATUSES)],
            'payment_status'=>['nullable',Rule::in(['pending','pending_cod','paid','failed','partially_refunded','refunded'])],
            'payment_method'=>['nullable','string','max:40'],
            'source'=>['nullable','string','max:120'],
            'product'=>['nullable','string','max:190'],
            'return_status'=>['nullable','string','max:40'],
            'refund_status'=>['nullable',Rule::in(['pending','initiated','completed','failed'])],
            'courier'=>['nullable','string','max:120'],
            'from'=>['nullable','date'],
            'to'=>['nullable','date','after_or_equal:from'],
            'min_amount'=>['nullable','numeric','gte:0'],
            'max_amount'=>['nullable','numeric','gte:0'],
            'sort'=>['nullable',Rule::in(['created_at','total','status'])],
            'direction'=>['nullable',Rule::in(['asc','desc'])],
        ]);
        if ($request->filled('min_amount') && $request->filled('max_amount') && (float) $request->input('max_amount') < (float) $request->input('min_amount')) {
            throw \Illuminate\Validation\ValidationException::withMessages(['max_amount'=>'Maximum amount must be at least the minimum amount.']);
        }
    }

    private function dateRange(Request $request): array
    {
        $data = $request->validate(['from'=>['nullable','date'],'to'=>['nullable','date','after_or_equal:from']]);
        return [isset($data['from']) ? now()->parse($data['from'])->startOfDay() : now()->subDays(29)->startOfDay(), isset($data['to']) ? now()->parse($data['to'])->endOfDay() : now()->endOfDay()];
    }
}
