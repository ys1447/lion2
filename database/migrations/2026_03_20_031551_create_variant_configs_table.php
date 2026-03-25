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
        Schema::create('variant_configs', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel variants
            $table->foreignId('variant_id')->unique()->constrained()->cascadeOnDelete();
            // Menyimpan array kolom dalam format JSON
            $table->json('visible_columns');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_configs');
    }
};
