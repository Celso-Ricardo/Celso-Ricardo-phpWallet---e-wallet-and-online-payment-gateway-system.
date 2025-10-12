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
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('deposits_user_id_foreign');
            $table->integer('transaction_state_id');
            $table->unsignedBigInteger('deposit_method_id')->nullable();
            $table->decimal('gross', 19, 8);
            $table->decimal('fee', 16, 8);
            $table->decimal('net', 19, 8);
            $table->text('transaction_receipt')->nullable();
            $table->text('json_data')->nullable();
            $table->unsignedBigInteger('currency_id')->index('deposits_currency_id_foreign');
            $table->string('currency_symbol')->nullable();
            $table->unsignedBigInteger('wallet_id')->index('deposits_wallet_id_foreign');
            $table->text('message')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('transfer_method_id')->nullable();
            $table->string('unique_transaction_id', 191)->nullable();
            $table->string('date_eposh')->default('CURRENT_TIMESTAMP')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
