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
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('wallets_user_id_foreign');
            $table->unsignedBigInteger('currency_id')->index('wallets_currency_id_foreign');
            $table->boolean('is_crypto')->default(false);
            $table->decimal('amount')->default(0);
            $table->decimal('crypto', 16, 8)->default(0);
            $table->decimal('fiat', 13)->default(0);
            $table->timestamps();
            $table->text('transfer_method_id')->nullable();
            $table->text('account_identifier_mechanism_value')->nullable();
            $table->string('wallet_identifier')->default('258');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
