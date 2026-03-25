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
        Schema::create('reagent_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_reagent_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'incoming' atau 'usage'
            $table->integer('amount');
            $table->string('user_name')->nullable(); // Siapa yang input
            $table->timestamps(); // Ini otomatis mencatat "Kapan" (created_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reagent_logs');
    }
};
