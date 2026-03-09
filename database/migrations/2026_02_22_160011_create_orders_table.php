<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('external_id')->unique();

            // Untuk Xendit Invoice
            $table->string('xendit_invoice_id')->nullable();
            $table->string('invoice_url')->nullable();

            // Untuk Virtual Account
            $table->string('va_number')->nullable();
            $table->string('bank')->nullable();

            $table->decimal('total_amount', 12, 2);

            // pending | paid | expired | failed
            $table->string('status')->default('pending');

            $table->string('payment_method')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};