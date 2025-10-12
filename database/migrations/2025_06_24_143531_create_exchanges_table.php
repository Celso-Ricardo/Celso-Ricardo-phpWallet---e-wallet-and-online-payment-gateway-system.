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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('exchanges_user_id_foreign');
            $table->unsignedBigInteger('first_currency_id')->index('exchanges_first_currency_id_foreign');
            $table->unsignedBigInteger('second_currency_id')->index('exchanges_second_currency_id_foreign');
            $table->decimal('gross', 19, 8)->nullable();
            $table->decimal('fee', 16, 8)->nullable();
            $table->decimal('net', 19, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
