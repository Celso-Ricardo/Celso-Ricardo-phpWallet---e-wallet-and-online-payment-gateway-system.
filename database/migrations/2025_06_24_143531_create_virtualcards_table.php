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
        Schema::create('virtualcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('virtual_card_id', 191);
            $table->unsignedBigInteger('user_id')->index('virtualcards_user_id_foreign');
            $table->unsignedBigInteger('currency_id')->nullable()->index('virtualcards_currency_id_foreign');
            $table->string('virtual_card_issuer', 191);
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('status')->nullable()->default(false);
            $table->string('status_string', 191)->nullable()->default('Inactive');
            $table->text('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtualcards');
    }
};
