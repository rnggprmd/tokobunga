<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'type', 'value', 'min_spend', 'max_discount',
        'start_date', 'expiry_date', 'usage_limit', 'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_spend' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];
}
