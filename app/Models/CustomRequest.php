<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomRequest extends Model
{
    protected $fillable = [
        'user_id', 'produk_id', 'foto_referensi', 'foto_request',
        'keterangan', 'status', 'harga_estimasi', 'customer_name',
        'customer_email', 'customer_phone', 'alamat', 'product_category'
    ];

    protected $casts = [
        'harga_estimasi' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
}
