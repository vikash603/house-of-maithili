<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id','product_id','product_variant_id','product_name','sku','size','color','unit_price','quantity','line_total'];

    protected function casts(): array
    {
        return ['unit_price'=>'decimal:2','line_total'=>'decimal:2','quantity'=>'integer'];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
