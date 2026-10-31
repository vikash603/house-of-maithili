<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','order_number','customer_name','email','phone','address','city','state','postal_code','order_notes',
        'subtotal','discount_amount','coupon_code','total','currency','payment_method','payment_status','status',
        'razorpay_order_id','razorpay_payment_id','paid_at','account_email_sent_at','account_auto_created_at',
    ];

    protected function casts(): array
    {
        return ['subtotal'=>'decimal:2','discount_amount'=>'decimal:2','total'=>'decimal:2','paid_at'=>'datetime','account_email_sent_at'=>'datetime','account_auto_created_at'=>'datetime'];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
