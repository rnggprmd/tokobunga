<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'total_harga', 'status', 'metode_pembayaran',
        'alamat_pengiriman', 'customer_name', 'customer_email', 'customer_phone',
        'is_stock_reduced'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'is_stock_reduced' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function pengiriman(): HasOne
    {
        return $this->hasOne(Pengiriman::class);
    }

    /**
     * Reduce stock for all items in this order.
     * Prevents duplicate reduction using is_stock_reduced flag.
     */
    public function reduceStock()
    {
        if ($this->is_stock_reduced) {
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () {
            foreach ($this->items as $item) {
                if ($item->product_id) {
                    $item->product()->decrement('stok', $item->jumlah);
                }
            }

            $this->update(['is_stock_reduced' => true]);
        });
    }
}
