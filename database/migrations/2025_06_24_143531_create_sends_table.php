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
        Schema::create('sends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('sends_user_id_foreign');
            $table->unsignedBigInteger('to_id')->index('sends_to_id_foreign');
            $table->integer('transaction_state_id');
            $table->decimal('gross', 19, 8);
            $table->decimal('fee', 16, 8);
            $table->decimal('net', 19, 8);
            $table->text('description');
            $table->text('json_data')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->unsignedBigInteger('currency_id')->index('sends_currency_id_foreign');
            $table->timestamps();
            $table->unsignedBigInteger('receive_id')->nullable()->index('sends_receive_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sends');
    }
};
