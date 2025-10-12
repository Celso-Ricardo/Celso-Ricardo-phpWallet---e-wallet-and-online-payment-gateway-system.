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
        Schema::create('admin_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stat_name', 191);
            $table->string('stat_value', 191);
            $table->unsignedBigInteger('currency_id')->index('admin_stats_currency_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_stats');
    }
};
