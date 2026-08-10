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
        'description',
        'price',
        'sale_price',
        'thumbnail',
        'stock',
        'status'
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
}
