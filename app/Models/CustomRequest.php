<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'produk_id', 'foto_referensi', 'foto_request',
        'keterangan', 'status', 'customer_name',
        'customer_email', 'customer_phone', 'alamat', 'product_category'
    ];

    protected $casts = [
        'user_id' => 'integer',
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
