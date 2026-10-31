<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['customer_name', 'title', 'quote', 'rating', 'photo', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['rating' => 'integer', 'is_active' => 'boolean', 'sort_order' => 'integer'];
    }
}
