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
        Schema::create('paymentlinkorders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paymentlink_id')->index('paymentlinkorders_paymentlink_id_foreign');
            $table->string('paymentlink_reference', 191);
            $table->string('link_paid_by_platform', 191);
            $table->text('json_data')->nullable();
            $table->string('email', 191)->nullable();
            $table->boolean('order_state')->default(false);
            $table->string('order_status', 191)->default('unpaid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentlinkorders');
    }
};
