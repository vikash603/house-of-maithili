<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountAccessCode extends Model
{
    protected $fillable = ['order_id', 'email', 'purpose', 'code_hash', 'attempts', 'expires_at', 'consumed_at'];

    protected function casts(): array
    {
        return ['expires_at' => 'datetime', 'consumed_at' => 'datetime', 'attempts' => 'integer'];
    }
}
