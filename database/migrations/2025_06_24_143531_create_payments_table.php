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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('payments_user_id_foreign');
            $table->unsignedBigInteger('to_id')->index('payments_to_id_foreign');
            $table->integer('transaction_state_id');
            $table->decimal('gross', 19, 8);
            $table->decimal('fee', 16, 8);
            $table->decimal('net', 19, 8);
            $table->text('description')->nullable();
            $table->text('json_data')->nullable();
            $table->unsignedBigInteger('item_id')->index('payments_item_id_foreign');
            $table->unsignedBigInteger('currency_id')->index('payments_currency_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
