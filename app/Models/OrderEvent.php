<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderEvent extends Model
{
    protected $fillable = ['order_id','actor_id','type','from_status','to_status','message','is_internal','metadata'];

    protected function casts(): array
    {
        return ['is_internal' => 'boolean', 'metadata' => 'array'];
    }

    public function order() { return $this->belongsTo(Order::class); }
    public function actor() { return $this->belongsTo(User::class, 'actor_id'); }
}
