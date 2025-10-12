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
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('items_user_id_foreign');
            $table->unsignedBigInteger('merchant_id')->nullable()->index('items_merchant_id_foreign');
            $table->string('name', 191);
            $table->string('code', 191);
            $table->text('description');
            $table->text('thumbnail')->nullable();
            $table->decimal('price', 16, 8)->default(0);
            $table->text('json_data')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable()->index('items_currency_id_foreign');
            $table->timestamps();
            $table->softDeletes();
            $table->longText('link')->nullable();
            $table->text('ipn_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
