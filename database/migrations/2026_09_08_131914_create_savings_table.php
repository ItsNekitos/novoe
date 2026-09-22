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
        //таблица Копилок / Финансовых целей (например, «Коплю на ноутбук»).
        Schema::create('savings_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Название цели (Например: Ноутбук)
            $table->float('target_amount'); // Сколько нужно собрать
            $table->float('current_amount')->default(100.90); // Сколько уже накоплено
            $table->date('deadline')->nullable(); // До какого числа нужно успеть
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
