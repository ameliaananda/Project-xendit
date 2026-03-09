<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * [REFACTOR] Migration ini hanya menambahkan kolom payment_channel_id.
     * Kolom payment_method dan external_id sudah ada di migration utama
     * (create_orders_table), jadi tidak ditambahkan lagi di sini.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_channel_id')->nullable();
        });
    }

    /**
     * [FIX] down() hanya drop payment_channel_id (yang benar-benar ditambahkan oleh migration ini).
     * Sebelumnya mencoba drop payment_method dan external_id yang bukan milik migration ini.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_channel_id');
        });
    }
};
