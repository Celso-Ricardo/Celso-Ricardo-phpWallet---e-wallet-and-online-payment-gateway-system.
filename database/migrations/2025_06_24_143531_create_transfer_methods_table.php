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
        Schema::create('transfer_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('currency_id')->index('transfer_methods_currency_id_foreign');
            $table->text('name')->nullable();
            $table->text('account_identifier_mechanism')->nullable();
            $table->text('how_to_deposit')->nullable();
            $table->text('how_to_withdraw')->nullable();
            $table->integer('days_to_process_transfer')->default(1);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->decimal('deposit_percentage_fee', 16, 8)->nullable()->default(0);
            $table->decimal('deposit_fixed_fee', 16, 8)->nullable()->default(0);
            $table->decimal('withdraw_percentage_fee', 16, 8)->nullable()->default(0);
            $table->decimal('withdraw_fixed_fee', 16, 8)->nullable()->default(0);
            $table->longText('thumbnail')->nullable();
            $table->decimal('merchant_fixed_fee', 16, 8)->nullable()->default(0);
            $table->decimal('merchant_percentage_fee', 16, 8)->nullable()->default(0);
            $table->longText('mobile_thumbnail')->nullable();
            $table->boolean('is_hidden')->nullable()->default(false);
            $table->boolean('is_system')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_methods');
    }
};
