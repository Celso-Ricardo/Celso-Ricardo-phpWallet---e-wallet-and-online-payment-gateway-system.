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
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('attempts')->default(0);
            $table->string('merchant_key', 191);
            $table->string('ref', 191);
            $table->boolean('is_expired');
            $table->text('data');
            $table->string('currency_code')->nullable();
            $table->unsignedBigInteger('currency_id')->index('requests_currency_id_foreign');
            $table->timestamps();
            $table->string('payeer_phone_number')->default('258');
            $table->string('order_id')->unique();
            $table->string('payment_status')->default('Pending');
            $table->string('total')->default('0.00');
            $table->unsignedBigInteger('user_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
