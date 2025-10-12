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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('vouchers_user_id_foreign');
            $table->string('voucher_code', 191);
            $table->text('json_data')->nullable();
            $table->unsignedBigInteger('currency_id')->index('vouchers_currency_id_foreign');
            $table->string('currency_symbol')->nullable();
            $table->integer('user_loader')->nullable();
            $table->boolean('is_loaded')->default(false);
            $table->decimal('voucher_fee', 16, 8)->nullable();
            $table->decimal('voucher_value', 19, 8)->nullable();
            $table->decimal('voucher_amount', 19, 8);
            $table->unsignedBigInteger('wallet_id')->index('vouchers_wallet_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
