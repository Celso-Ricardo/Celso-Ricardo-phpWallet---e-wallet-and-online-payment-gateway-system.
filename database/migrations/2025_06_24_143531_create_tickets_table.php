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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('tickets_user_id_foreign');
            $table->unsignedBigInteger('ticketcategory_id')->index('tickets_ticketcategory_id_foreign');
            $table->unsignedBigInteger('ticket_id')->index('tickets_ticket_id_foreign');
            $table->string('title')->nullable();
            $table->string('priority')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
