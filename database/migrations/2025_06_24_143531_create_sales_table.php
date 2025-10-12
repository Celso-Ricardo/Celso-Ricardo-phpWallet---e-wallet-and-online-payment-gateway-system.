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
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('sales_user_id_foreign');
            $table->unsignedBigInteger('merchant_id')->index('sales_merchant_id_foreign');
            $table->integer('transaction_state_id');
            $table->decimal('gross', 19, 8);
            $table->decimal('fee', 16, 8);
            $table->decimal('net', 19, 8);
            $table->text('json_data')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->unsignedBigInteger('currency_id')->index('sales_currency_id_foreign');
            $table->timestamps();
            $table->unsignedBigInteger('purchase_id')->nullable()->index('sales_purchase_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
