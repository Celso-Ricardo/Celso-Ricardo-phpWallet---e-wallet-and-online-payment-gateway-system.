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
        Schema::create('investmentplans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transfer_method_id')->index('investmentplans_transfer_method_id_foreign');
            $table->text('name')->nullable();
            $table->integer('min_profit_percentage')->nullable();
            $table->integer('max_profit_percentage')->nullable();
            $table->decimal('min_investment', 16, 8)->default(0);
            $table->decimal('max_investment', 16, 8)->default(0);
            $table->text('withdraw_interval_days')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investmentplans');
    }
};
