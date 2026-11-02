<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    protected $fillable = ['order_id','requested_by','reviewed_by','status','customer_reason','staff_notes','reviewed_at'];
    protected function casts(): array { return ['reviewed_at' => 'datetime']; }
    public function order() { return $this->belongsTo(Order::class); }
}
