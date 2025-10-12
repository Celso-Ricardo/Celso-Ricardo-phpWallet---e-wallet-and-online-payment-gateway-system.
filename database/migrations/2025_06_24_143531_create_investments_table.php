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
        Schema::create('investments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('investments_user_id_foreign');
            $table->unsignedBigInteger('investmentplan_id')->index('investments_investmentplan_id_foreign');
            $table->decimal('capital', 16, 8)->default(0);
            $table->decimal('earnings', 16, 8)->default(0);
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('is_crypto')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
