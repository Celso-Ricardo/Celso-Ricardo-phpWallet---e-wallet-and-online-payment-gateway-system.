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
        Schema::create('virtualcardrequests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('virtualcard_id', 191);
            $table->string('virtualcarddetail_id', 191);
            $table->unsignedBigInteger('user_id')->index('virtualcardrequests_user_id_foreign');
            $table->unsignedBigInteger('currency_id')->nullable()->index('virtualcardrequests_currency_id_foreign');
            $table->string('virtual_card_issuer', 191);
            $table->boolean('status')->default(false);
            $table->text('request_resolution');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtualcardrequests');
    }
};
