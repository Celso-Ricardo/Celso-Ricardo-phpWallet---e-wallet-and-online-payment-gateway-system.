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
        Schema::create('paymentlinks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('paymentlink_id', 191)->nullable();
            $table->unsignedBigInteger('user_id')->index('paymentlinks_user_id_foreign');
            $table->unsignedBigInteger('currency_id')->nullable()->index('paymentlinks_currency_id_foreign');
            $table->text('paymentlink_details')->nullable();
            $table->decimal('amount', 16, 8)->default(0);
            $table->string('email', 191)->nullable();
            $table->boolean('is_crypto')->default(false);
            $table->boolean('payment_status')->default(false);
            $table->boolean('link_status')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->text('ipn_url')->nullable();
            $table->text('link')->nullable();
            $table->string('name', 191);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentlinks');
    }
};
