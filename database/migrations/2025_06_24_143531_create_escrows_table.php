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
        Schema::create('escrows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('escrows_user_id_foreign');
            $table->unsignedBigInteger('to')->index('escrows_to_foreign');
            $table->decimal('gross', 19, 8)->nullable();
            $table->text('description')->nullable();
            $table->text('json_data')->nullable();
            $table->unsignedBigInteger('currency_id')->index('escrows_currency_id_foreign');
            $table->string('currency_symbol', 10)->nullable();
            $table->string('escrow_transaction_status')->nullable();
            $table->boolean('agreement')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escrows');
    }
};
