<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rework_logs', function (Blueprint $table) {
            $table->id();
            // Relasi ke data batch asli
            $table->foreignId('input_data_id')->constrained('input_data')->onDelete('cascade');

            // Data Stok & Status
            $table->decimal('initial_quantity', 10, 2); // Kuota awal kg
            $table->decimal('current_quantity', 10, 2); // Sisa kg yang terus berkurang

            $table->enum('status', ['active', 'done'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rework_logs');
    }
};
