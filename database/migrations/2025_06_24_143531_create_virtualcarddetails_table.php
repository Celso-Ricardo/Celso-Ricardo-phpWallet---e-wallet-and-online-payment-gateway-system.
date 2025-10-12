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
        Schema::create('virtualcarddetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('virtualcard_id')->index('virtualcarddetails_virtualcard_id_foreign');
            $table->text('card_id');
            $table->text('hash');
            $table->text('pan')->nullable();
            $table->text('masked_pan');
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->text('address')->nullable();
            $table->text('address_2')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->decimal('amount', 9)->default(0);
            $table->string('name_on_card', 191);
            $table->string('zip_code', 191);
            $table->integer('cvv');
            $table->string('expiration', 191);
            $table->text('card_created_at');
            $table->string('send_to', 191)->nullable();
            $table->string('bin_check_name', 191)->nullable();
            $table->string('card_type', 191)->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('card_is_active', 191)->default('false');
            $table->text('callback_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtualcarddetails');
    }
};
