<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderItem;
use App\Models\OrderRefund;
use App\Models\User;
use App\Services\OrderWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class OrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::factory()->create(['email'=>User::AUTHORIZED_ADMIN_EMAIL,'email_verified_at'=>now()]);
    }

    private function order(array $attributes = []): Order
    {
        return Order::create(array_merge([
            'order_number' => 'HOM-TEST-'.uniqid(), 'customer_name' => 'Test Customer', 'email' => 'customer@example.test',
            'phone' => '9876543210', 'address' => '1 Test Street', 'city' => 'Patna', 'state' => 'Bihar', 'postal_code' => '800001',
            'subtotal' => 1000, 'discount_amount' => 0, 'total' => 1000, 'currency' => 'INR', 'payment_method' => 'cod',
            'payment_status' => 'pending_cod', 'status' => 'placed',
        ], $attributes));
    }

    public function test_only_valid_order_transitions_are_applied_and_audited(): void
    {
        $order = $this->order();
        $admin = $this->adminUser();
        $updated = app(OrderWorkflowService::class)->transition($order, 'pending_approval', null, $admin->id);

        $this->assertSame('pending_approval', $updated->status);
        $this->assertDatabaseHas('order_events', ['order_id' => $order->id, 'from_status' => 'placed', 'to_status' => 'pending_approval', 'actor_id' => $admin->id]);
    }

    public function test_skipping_required_fulfilment_states_is_rejected(): void
    {
        $this->expectException(ValidationException::class);
        app(OrderWorkflowService::class)->transition($this->order(), 'shipped', null, null);
    }

    public function test_cancellation_and_return_rejection_require_a_reason(): void
    {
        foreach ([['confirmed','cancelled'],['return_requested','return_rejected']] as [$from,$to]) {
            try {
                app(OrderWorkflowService::class)->transition($this->order(['status'=>$from]),$to,null,null);
                $this->fail('A cancellation or return rejection without a reason must be refused.');
            } catch (ValidationException $exception) {
                $this->assertArrayHasKey('reason',$exception->errors());
            }
        }
    }

    public function test_dispatch_requires_real_courier_and_tracking_details(): void
    {
        $this->expectException(ValidationException::class);
        app(OrderWorkflowService::class)->transition($this->order(['status'=>'ready_to_ship']), 'shipped', null, null);
    }

    public function test_cod_collection_cannot_be_recorded_before_delivery(): void
    {
        $admin = $this->adminUser();
        $order = $this->order(['status'=>'out_for_delivery']);

        $this->actingAs($admin)->from(route('admin.orders.show', $order))
            ->post(route('admin.orders.cod-paid', $order))
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHasErrors('payment_status');

        $this->assertSame('pending_cod', $order->fresh()->payment_status);
        $this->assertDatabaseMissing('order_events', ['order_id' => $order->id, 'type' => 'payment']);
    }

    public function test_cod_collection_can_be_recorded_once_after_delivery(): void
    {
        $admin = $this->adminUser();
        $order = $this->order(['status'=>'delivered']);

        $this->actingAs($admin)->post(route('admin.orders.cod-paid', $order))->assertRedirect();
        $this->post(route('admin.orders.cod-paid', $order))->assertRedirect();

        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame(1, OrderEvent::query()->where('order_id', $order->id)->where('type', 'payment')->count());
    }

    public function test_refund_total_cannot_exceed_captured_amount_after_previous_refunds(): void
    {
        $admin = $this->adminUser();
        $order = $this->order(['status'=>'returned','payment_status'=>'paid']);
        OrderRefund::create(['order_id'=>$order->id,'recorded_by'=>$admin->id,'amount'=>800,'status'=>'pending']);

        $this->actingAs($admin)->from(route('admin.orders.show', $order))
            ->post(route('admin.orders.refunds', $order), ['amount'=>300,'status'=>'pending','notes'=>'Approved after return review'])
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHasErrors('amount');

        $this->assertSame(1, $order->refunds()->count());
    }

    public function test_refund_transaction_reference_cannot_be_recorded_twice(): void
    {
        $admin = $this->adminUser();
        $order = $this->order(['status'=>'returned','payment_status'=>'paid']);
        OrderRefund::create(['order_id'=>$order->id,'recorded_by'=>$admin->id,'amount'=>100,'status'=>'pending','transaction_reference'=>'REF-ONCE']);

        $this->actingAs($admin)->from(route('admin.orders.show', $order))
            ->post(route('admin.orders.refunds', $order), ['amount'=>100,'status'=>'pending','transaction_reference'=>'REF-ONCE','notes'=>'Duplicate reference check'])
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHasErrors('transaction_reference');

        $this->assertSame(1, $order->refunds()->count());
    }

    public function test_missing_shipping_details_block_dispatch(): void
    {
        $admin = $this->adminUser();
        $order = $this->order(['status'=>'ready_to_ship']);

        $this->actingAs($admin)->from(route('admin.orders.show', $order))
            ->patch(route('admin.orders.status', $order), ['status'=>'shipped'])
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHasErrors('status');

        $this->assertSame('ready_to_ship', $order->fresh()->status);
    }

    public function test_shipping_rejects_unsafe_tracking_urls_and_past_delivery_dates(): void
    {
        $admin = $this->adminUser();
        $order = $this->order();

        $this->actingAs($admin)->from(route('admin.orders.show', $order))
            ->patch(route('admin.orders.shipping', $order), [
                'courier_name'=>'Test Courier',
                'tracking_number'=>'AWB-123',
                'tracking_url'=>'javascript:alert(1)',
                'expected_delivery_at'=>now()->subDay()->toDateString(),
            ])
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHasErrors(['tracking_url','expected_delivery_at']);

        $this->assertNull($order->fresh()->tracking_url);
        $this->assertNull($order->fresh()->expected_delivery_at);
    }

    public function test_order_detail_shows_recorded_item_and_order_totals(): void
    {
        $admin = $this->adminUser();
        $order = $this->order(['subtotal'=>1400,'discount_amount'=>200,'total'=>1200,'coupon_code'=>'CRAFT200']);
        OrderItem::create(['order_id'=>$order->id,'product_name'=>'Handcrafted Saree','sku'=>'HOM-SAR-01','unit_price'=>700,'quantity'=>2,'line_total'=>1400]);

        $this->actingAs($admin)->get(route('admin.orders.show',$order))
            ->assertOk()
            ->assertSee('HOM-SAR-01')
            ->assertSee('Handcrafted Saree')
            ->assertSee('1,400.00')
            ->assertSee('CRAFT200')
            ->assertSee('−₹200.00')
            ->assertSee('1,200.00')
            ->assertSee('1 Test Street')
            ->assertSee('Patna, Bihar 800001');
    }

    public function test_order_actions_are_denied_to_unauthorized_users(): void
    {
        $user = User::factory()->create();
        $order = $this->order();
        $this->actingAs($user);

        $this->get(route('admin.orders.show', $order))->assertForbidden();
        $this->patch(route('admin.orders.status', $order), ['status'=>'confirmed'])->assertForbidden();
        $this->patch(route('admin.orders.shipping', $order), [])->assertForbidden();
        $this->post(route('admin.orders.notes', $order), ['note'=>'not allowed'])->assertForbidden();
        $this->post(route('admin.orders.refunds', $order), ['amount'=>1,'status'=>'pending'])->assertForbidden();
        $this->post(route('admin.orders.cod-paid', $order))->assertForbidden();
    }

    public function test_internal_staff_notes_are_not_shown_to_customers(): void
    {
        $customer = User::factory()->create(['is_admin'=>false]);
        $order = $this->order(['user_id'=>$customer->id]);
        OrderEvent::create(['order_id'=>$order->id,'actor_id'=>$customer->id,'type'=>'note','message'=>'Staff only confidential note','is_internal'=>true]);

        $this->actingAs($customer)->get(route('account.orders.show', $order))
            ->assertOk()
            ->assertDontSee('Staff only confidential note');
    }

    public function test_customers_can_only_view_their_own_orders(): void
    {
        $customer = User::factory()->create();
        $otherCustomer = User::factory()->create();
        $ownOrder = $this->order(['user_id'=>$customer->id]);
        $privateOrder = $this->order(['user_id'=>$otherCustomer->id]);

        $this->actingAs($customer)->get(route('account.orders.index'))
            ->assertOk()->assertSee($ownOrder->order_number)->assertDontSee($privateOrder->order_number);
        $this->get(route('account.orders.show',$ownOrder))->assertOk()->assertSee($ownOrder->order_number);
        $this->get(route('account.orders.show',$privateOrder))->assertNotFound();
    }

    public function test_order_management_is_denied_to_non_admin_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('admin.orders.dashboard'))->assertForbidden();
    }

    public function test_backend_catalog_routes_are_also_limited_to_admin_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('banners.index'))->assertForbidden();
    }

    public function test_alternate_allowlists_and_legacy_admin_flags_cannot_grant_access(): void
    {
        config(['orders.admin_emails' => 'orders@example.test', 'admin.emails' => '']);
        $user = User::factory()->create(['email' => 'orders@example.test', 'email_verified_at'=>now()]);
        $legacyFlagUser = User::factory()->create(['email' => 'flagged@example.test', 'email_verified_at'=>now(), 'is_admin'=>true]);

        $this->actingAs($user)->get(route('admin.orders.dashboard'))->assertForbidden();
        $this->actingAs($legacyFlagUser)->get(route('admin.orders.dashboard'))->assertForbidden();
        $this->get(route('banners.index'))->assertForbidden();
    }

    public function test_only_normalized_authorized_email_can_access_admin_routes(): void
    {
        config(['admin.emails' => 'panel@example.test', 'orders.admin_emails' => '']);
        $user = User::factory()->create(['email' => 'HOUSEOFMAITHILI@GMAIL.COM', 'email_verified_at'=>now()]);

        $this->actingAs($user)->get(route('banners.index'))->assertOk();
        $this->get(route('admin.orders.dashboard'))->assertOk();
    }

    public function test_unverified_authorized_email_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create(['email'=>User::AUTHORIZED_ADMIN_EMAIL,'email_verified_at'=>null]);

        $this->actingAs($user)->get(route('admin.orders.dashboard'))->assertRedirect(route('verification.notice'));
    }

    public function test_admin_can_open_dashboard_order_list_and_order_detail(): void
    {
        $admin = $this->adminUser();
        $order = $this->order(['user_id' => $admin->id]);
        $this->actingAs($admin);
        $dashboard = $this->get(route('admin.orders.dashboard'));
        $dashboard->assertOk()->assertSee('Order dashboard')->assertSee('Customers in period')->assertSee('Low stock products')
            ->assertSee(route('admin.orders.index'))->assertDontSee('order-list.html')->assertDontSee('transactions.html');
        $this->get(route('admin.orders.index'))->assertOk()->assertSee($order->order_number);
        $this->get(route('admin.orders.index',['status'=>'not-a-valid-status']))->assertSessionHasErrors('status');
        $this->get(route('admin.orders.show',$order))->assertOk()->assertSee('Shipping');
        $this->get(route('dashboard'))->assertRedirect(route('admin.orders.dashboard'));
    }

    public function test_dashboard_date_range_filters_orders_metrics_and_customer_activity(): void
    {
        $admin = $this->adminUser();
        $inRangeCustomer = User::factory()->create(['is_admin' => false]);
        $oldRangeCustomer = User::factory()->create(['is_admin' => false]);
        $inRangeDate = now()->subDays(2);
        $oldRangeDate = now()->subDays(60);

        $inRangeOrder = $this->order([
            'user_id' => $inRangeCustomer->id,
            'customer_name' => 'Current Range Customer',
            'email' => $inRangeCustomer->email,
            'status' => 'delivered',
            'payment_method' => 'cod',
            'payment_status' => 'paid',
            'source' => 'newsletter',
            'total' => 1250,
            'created_at' => $inRangeDate,
            'updated_at' => $inRangeDate,
        ]);
        $oldRangeOrder = $this->order([
            'user_id' => $oldRangeCustomer->id,
            'customer_name' => 'Old Range Customer',
            'email' => $oldRangeCustomer->email,
            'created_at' => $oldRangeDate,
            'updated_at' => $oldRangeDate,
        ]);
        DB::table('orders')->where('id', $inRangeOrder->id)->update(['created_at' => $inRangeDate, 'updated_at' => $inRangeDate]);
        DB::table('orders')->where('id', $oldRangeOrder->id)->update(['created_at' => $oldRangeDate, 'updated_at' => $oldRangeDate]);
        OrderItem::create([
            'order_id' => $inRangeOrder->id,
            'product_name' => 'Range Test Product',
            'unit_price' => 1250,
            'quantity' => 1,
            'line_total' => 1250,
        ]);
        OrderItem::create([
            'order_id' => $oldRangeOrder->id,
            'product_name' => 'Old Range Product',
            'unit_price' => 1000,
            'quantity' => 1,
            'line_total' => 1000,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.orders.dashboard', [
                'from' => $inRangeDate->toDateString(),
                'to' => $inRangeDate->toDateString(),
            ]))
            ->assertOk()
            ->assertSee($inRangeOrder->order_number)
            ->assertSee('Current Range Customer')
            ->assertSee($inRangeCustomer->email)
            ->assertSee('Range Test Product')
            ->assertSee('newsletter')
            ->assertSee('COD')
            ->assertSee('₹1,250.00')
            ->assertDontSee($oldRangeOrder->order_number)
            ->assertDontSee('Old Range Customer')
            ->assertDontSee('Old Range Product');
    }
}
