<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('nama_penerima');
            $table->text('alamat_pengiriman');
            $table->string('no_hp', 20);
            $table->string('kurir')->nullable();
            $table->string('no_resi')->nullable();
            $table->enum('status_pengiriman', ['pending', 'dikirim', 'sampai', 'dibatalkan'])->default('pending');
            $table->date('tanggal_kirim')->nullable();
            $table->date('tanggal_terima')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
