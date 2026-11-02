<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRefund extends Model
{
    protected $fillable = ['order_id','return_id','recorded_by','amount','status','method','transaction_reference','notes','completed_at'];
    protected function casts(): array { return ['amount' => 'decimal:2', 'completed_at' => 'datetime']; }
    public function order() { return $this->belongsTo(Order::class); }
}
