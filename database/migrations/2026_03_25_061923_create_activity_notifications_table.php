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
        Schema::create('activity_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('user_name'); // Siapa
            $table->string('action');    // Edit / Delete
            $table->string('target');    // Nama Reagent / ID Log
            $table->text('details');     // Detail perubahan (misal: 100ml -> 200ml)
            $table->timestamps();        // Jam berapa (created_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_notifications');
    }
};
