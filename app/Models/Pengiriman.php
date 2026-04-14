<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengiriman extends Model
{
    use SoftDeletes;

    protected $table = 'pengiriman';

    protected $fillable = [
        'order_id', 'kurir_id', 'nama_penerima', 'alamat_pengiriman', 'no_hp',
        'kurir', 'no_resi', 'no_hp_kurir', 'status_pengiriman', 'tanggal_kirim', 'tanggal_terima'
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
        'tanggal_terima' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function assignedKurir(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'kurir_id');
    }
}
