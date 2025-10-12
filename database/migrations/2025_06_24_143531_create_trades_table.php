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
        Schema::create('trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('trades_user_id_foreign');
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->unsignedBigInteger('currency_id')->index('trades_currency_id_foreign');
            $table->unsignedBigInteger('wallet_id')->index('trades_wallet_id_foreign');
            $table->boolean('buy_sell');
            $table->decimal('price', 16, 8)->default(0);
            $table->decimal('quantity', 16, 8)->default(0);
            $table->boolean('is_crypto')->default(false);
            $table->string('status_name', 191)->default('active');
            $table->integer('state')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
