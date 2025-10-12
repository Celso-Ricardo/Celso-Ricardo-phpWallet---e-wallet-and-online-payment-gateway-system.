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
        Schema::table('currency_withdrawal_methods', function (Blueprint $table) {
            $table->foreign(['currency_id'])->references(['id'])->on('currencies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['withdrawal_method_id'])->references(['id'])->on('withdrawal_methods')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('currency_withdrawal_methods', function (Blueprint $table) {
            $table->dropForeign('currency_withdrawal_methods_currency_id_foreign');
            $table->dropForeign('currency_withdrawal_methods_withdrawal_method_id_foreign');
        });
    }
};
