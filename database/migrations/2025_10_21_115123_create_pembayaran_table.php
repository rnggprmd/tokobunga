<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('metode_pembayaran');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->string('bukti_bayar')->nullable();
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'refund'])->default('pending');
            $table->datetime('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
