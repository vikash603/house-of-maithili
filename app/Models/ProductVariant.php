<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{

    protected $fillable = [
        'product_id',
        'size',
        'color',
        'price',
        'sale_price',
        'stock',
        'sku',
        'is_active',
    ];
    public function product()
{
    return $this->belongsTo(Product::class);
}

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
