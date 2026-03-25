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
        Schema::create('input_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained()->cascadeOnDelete();

            // relation
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_mixing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('machine_id')->constrained()->cascadeOnDelete();
            

            // Production info
            $table->string('batch')->nullable();
            $table->string('job_number')->nullable();
            

            // pH
            $table->decimal('ph_1', 5, 2)->nullable();
            $table->decimal('ph_2', 5, 2)->nullable();
            $table->decimal('ph_3', 5, 2)->nullable();

            // Viscosity
            $table->decimal('viscosity_1', 8, 2)->nullable();
            $table->decimal('viscosity_2', 8, 2)->nullable();
            $table->decimal('viscosity_3', 8, 2)->nullable();

            // Other parameters
            $table->decimal('specific_gravity', 6, 3)->nullable();
            $table->decimal('active_ingredient', 6, 2)->nullable();
            $table->decimal('zpt', 6, 2)->nullable();
            $table->decimal('soap_percentage', 5, 2)->nullable();

            // Chemical adjustments
            $table->decimal('rad', 6, 2)->nullable();
            $table->decimal('rgx', 6, 2)->nullable();
            $table->decimal('rxb', 6, 2)->nullable();
            $table->decimal('ryc', 6, 2)->nullable();

            // Organoleptic
            $table->string('appearance')->nullable();
            $table->string('odor')->nullable();

            // Production details
            $table->decimal('capacity', 10, 2)->nullable();
            $table->string('shift')->nullable();
            $table->string('job_code')->nullable();

            // Notes
            $table->text('notes')->nullable();

            $table->string('status')->default('releaseHold');
            $table->boolean('co_job')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_data');
    }
};
