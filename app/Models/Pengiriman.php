<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';

    protected $fillable = [
        'order_id', 'nama_penerima', 'alamat_pengiriman', 'no_hp',
        'kurir', 'no_resi', 'status_pengiriman', 'tanggal_kirim', 'tanggal_terima'
    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
        'tanggal_terima' => 'date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
