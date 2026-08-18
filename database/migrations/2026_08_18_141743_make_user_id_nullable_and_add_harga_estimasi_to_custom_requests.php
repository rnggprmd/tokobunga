<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Makes user_id nullable in custom_requests (guests can submit custom orders)
     * - Adds harga_estimasi column for admin price estimation
     */
    public function up(): void
    {
        Schema::table('custom_requests', function (Blueprint $table) {
            // Allow guests (unauthenticated users) to submit custom requests
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Add price estimation field if it doesn't exist
            if (!Schema::hasColumn('custom_requests', 'harga_estimasi')) {
                $table->decimal('harga_estimasi', 12, 2)->nullable()->after('product_category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            if (Schema::hasColumn('custom_requests', 'harga_estimasi')) {
                $table->dropColumn('harga_estimasi');
            }
        });
    }
};
