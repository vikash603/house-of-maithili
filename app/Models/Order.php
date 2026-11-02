<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','order_number','customer_name','email','phone','address','city','state','postal_code','order_notes',
        'subtotal','discount_amount','coupon_code','total','currency','payment_method','payment_status','status',
        'razorpay_order_id','razorpay_payment_id','paid_at','account_email_sent_at','account_auto_created_at',
        'source','utm_source','utm_medium','utm_campaign','utm_content','referrer_url','courier_name','tracking_number','tracking_url','shipped_at','expected_delivery_at','delivered_at','return_status','refund_status','approved_at','approved_by',
    ];

    protected function casts(): array
    {
        return ['subtotal'=>'decimal:2','discount_amount'=>'decimal:2','total'=>'decimal:2','paid_at'=>'datetime','account_email_sent_at'=>'datetime','account_auto_created_at'=>'datetime','shipped_at'=>'datetime','delivered_at'=>'datetime','expected_delivery_at'=>'date','approved_at'=>'datetime'];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function events() { return $this->hasMany(OrderEvent::class)->latest(); }
    public function returns() { return $this->hasMany(OrderReturn::class)->latest(); }
    public function refunds() { return $this->hasMany(OrderRefund::class)->latest(); }
}
