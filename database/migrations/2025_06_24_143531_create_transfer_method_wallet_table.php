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
        Schema::create('transfer_method_wallet', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('wallet_id')->index('transfer_method_wallet_wallet_id_foreign');
            $table->unsignedBigInteger('transfer_method_id')->index('transfer_method_wallet_transfer_method_id_foreign');
            $table->timestamps();
            $table->text('adress')->nullable();
            $table->unsignedBigInteger('user_id')->index('transfer_method_wallet_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_method_wallet');
    }
};
