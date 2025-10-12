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
        Schema::table('sends', function (Blueprint $table) {
            $table->foreign(['currency_id'])->references(['id'])->on('currencies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['receive_id'])->references(['id'])->on('receives')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['to_id'])->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sends', function (Blueprint $table) {
            $table->dropForeign('sends_currency_id_foreign');
            $table->dropForeign('sends_receive_id_foreign');
            $table->dropForeign('sends_to_id_foreign');
            $table->dropForeign('sends_user_id_foreign');
        });
    }
};
