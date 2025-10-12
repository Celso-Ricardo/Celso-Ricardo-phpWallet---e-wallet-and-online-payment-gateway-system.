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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('withdrawals_user_id_foreign');
            $table->integer('transaction_state_id');
            $table->decimal('gross', 19, 8);
            $table->decimal('fee', 16, 8);
            $table->decimal('net', 19, 8);
            $table->text('platform_id');
            $table->text('json_data')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->unsignedBigInteger('wallet_id')->index('withdrawals_wallet_id_foreign');
            $table->string('send_to_platform_name')->nullable();
            $table->unsignedBigInteger('currency_id')->index('withdrawals_currency_id_foreign');
            $table->timestamps();
            $table->unsignedBigInteger('transfer_method_id')->nullable();
            $table->text('unique_transaction_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
