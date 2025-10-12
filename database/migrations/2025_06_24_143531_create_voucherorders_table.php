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
        Schema::create('voucherorders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('voucher_id')->nullable();
            $table->unsignedBigInteger('user_id')->index('voucherorders_user_id_foreign');
            $table->unsignedBigInteger('currency_id')->index('voucherorders_currency_id_foreign');
            $table->decimal('amount', 16, 8)->default(0);
            $table->decimal('fee', 16, 8)->default(0);
            $table->decimal('total', 16, 8)->default(0);
            $table->boolean('is_crypto')->default(false);
            $table->string('order_status', 191)->default('active');
            $table->string('payment_method', 191)->nullable();
            $table->text('out_transaction_id');
            $table->integer('state')->default(1);
            $table->timestamps();
            $table->text('vorderid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucherorders');
    }
};
