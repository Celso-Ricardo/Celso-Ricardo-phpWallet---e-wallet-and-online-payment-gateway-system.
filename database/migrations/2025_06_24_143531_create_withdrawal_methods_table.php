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
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191);
            $table->longText('comment')->nullable();
            $table->decimal('percentage_fee', 5);
            $table->decimal('fixed_fee', 16, 8)->default(0);
            $table->text('json_data')->nullable();
            $table->string('thumb', 191)->nullable();
            $table->string('method_identifier_field__name', 191)->nullable();
            $table->timestamps();
            $table->longText('how_to_api')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable()->index('withdrawal_methods_currency_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_methods');
    }
};
