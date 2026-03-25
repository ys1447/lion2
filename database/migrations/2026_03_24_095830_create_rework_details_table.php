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
        Schema::create('rework_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rework_log_id')->constrained('rework_logs')->onDelete('cascade');
            $table->decimal('quantity_used', 10, 2);
            $table->string('target_batch_number');
            $table->string('shift');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rework_details');
    }
};
