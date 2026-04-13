<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('custom_requests', function (Blueprint $table) {
            $table->dropColumn('harga_estimasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_requests', function (Blueprint $table) {
            $table->decimal('harga_estimasi', 10, 2)->default(0);
        });
    }
};
