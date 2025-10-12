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
        Schema::table('currency_exchange_rates', function (Blueprint $table) {
            $table->foreign(['first_currency_id'])->references(['id'])->on('currencies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['second_currency_id'])->references(['id'])->on('currencies')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('currency_exchange_rates', function (Blueprint $table) {
            $table->dropForeign('currency_exchange_rates_first_currency_id_foreign');
            $table->dropForeign('currency_exchange_rates_second_currency_id_foreign');
        });
    }
};
