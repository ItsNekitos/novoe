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
        Schema::create('limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balance_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('max_summ');
            $table->date('rashod_limit_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limits');
    }
};
