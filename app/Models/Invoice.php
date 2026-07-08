<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'invoice_number',
    ];

    /**
     * Get the order that owns the invoice.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Generate a new invoice number automatically.
     * Format: INV-000001
     *
     * @return string
     */
    public static function generateInvoiceNumber(): string
    {
        $lastInvoice = self::orderBy('id', 'desc')->first();

        if (!$lastInvoice) {
            $number = 1;
        } else {
            // Extract the number part and increment
            $number = (int) str_replace('INV-', '', $lastInvoice->invoice_number) + 1;
        }

        return 'INV-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
