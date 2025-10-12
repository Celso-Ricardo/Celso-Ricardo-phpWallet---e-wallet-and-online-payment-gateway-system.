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
        Schema::create('closed_trades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->index('closed_trades_user_id_foreign');
            $table->unsignedBigInteger('trade_id')->index('closed_trades_trade_id_foreign');
            $table->unsignedBigInteger('trader_id')->index('closed_trades_trader_id_foreign');
            $table->decimal('quantity', 16, 8)->default(0);
            $table->boolean('is_crypto')->default(false);
            $table->string('status_name', 191)->default('bought');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closed_trades');
    }
};
