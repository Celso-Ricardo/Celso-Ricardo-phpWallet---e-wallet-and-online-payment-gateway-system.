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
        Schema::create('merchants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('merchants_user_id_foreign');
            $table->text('merchant_key');
            $table->string('site_url', 191);
            $table->string('success_link', 191);
            $table->string('fail_link', 191);
            $table->string('logo', 191)->nullable();
            $table->string('name', 191);
            $table->string('description', 191)->nullable();
            $table->text('json_data')->nullable();
            $table->unsignedBigInteger('currency_id')->index('merchants_currency_id_foreign');
            $table->string('thumb', 191)->nullable();
            $table->timestamps();
            $table->string('ipn_url', 191)->nullable();
            $table->string('total_sales')->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
