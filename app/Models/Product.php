<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'brand',
        'sku',
        'short_description',
        'description',
        'price',
        'sale_price',
        'thumbnail',
        'stock',
        'status',
        'is_featured',
        'is_trending',
        'is_made_to_order',
        'lead_time_days',
    ];
    
    public function images()
{
    return $this->hasMany(ProductImage::class);
}

public function variants()
{
    return $this->hasMany(ProductVariant::class);
}

public function category()
{
    return $this->belongsTo(Category::class);
}

public function subcategory()
{
    return $this->belongsTo(SubCategory::class);
}

    protected function casts(): array
    {
        return [
            'is_made_to_order' => 'boolean',
            'lead_time_days' => 'integer',
            'stock' => 'integer',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
        ];
    }
}
