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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign(['ticketcategory_id'])->references(['id'])->on('ticketcategories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['ticket_id'])->references(['id'])->on('tickets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_ticketcategory_id_foreign');
            $table->dropForeign('tickets_ticket_id_foreign');
            $table->dropForeign('tickets_user_id_foreign');
        });
    }
};
