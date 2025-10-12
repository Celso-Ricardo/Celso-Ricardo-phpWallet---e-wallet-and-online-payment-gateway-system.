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
        Schema::create('transactionable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('transactionable_user_id_foreign');
            $table->integer('request_id')->nullable();
            $table->integer('transactionable_id');
            $table->string('transactionable_type', 191);
            $table->integer('entity_id');
            $table->string('entity_name', 191);
            $table->integer('transaction_state_id');
            $table->string('currency', 191)->default('USD');
            $table->string('activity_title', 191);
            $table->string('money_flow', 191);
            $table->decimal('gross', 19, 8);
            $table->decimal('fee', 16, 8);
            $table->decimal('net', 19, 8);
            $table->decimal('balance', 19, 8)->nullable();
            $table->text('json_data')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('thumb', 191)->default('users/default.png');
            $table->unsignedBigInteger('currency_id')->index('transactionable_currency_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactionable');
    }
};
