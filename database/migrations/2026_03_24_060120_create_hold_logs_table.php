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
        Schema::create('hold_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('input_data_id')->constrained('input_data')->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // Siapa yang nge-hold
            $table->text('reason'); // Alasan yang diketik di modal
            $table->timestamp('hold_at'); // Waktu mulai hold
            $table->timestamp('released_at')->nullable(); // Waktu dilepas (null jika masih hold)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hold_logs');
    }
};
