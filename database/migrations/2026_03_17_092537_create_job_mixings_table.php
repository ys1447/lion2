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
        Schema::create('job_mixings', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('variant_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('name');
            $table->boolean('type')->default(true);
            $table->text('code_job_mixing');
            $table->string('capacity');
            $table->string('no_document');
            $table->string('no_ftd');
            $table->string('no_revisi');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_mixings');
    }
};
