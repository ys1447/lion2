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
        Schema::create('stock_reagents', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Menggunakan integer agar performa cepat (satuan ML)
            $table->integer('initial_stock')->default(0);  // Stok awal input pertama
            $table->integer('total_incoming')->default(0); // Total kumulatif stok masuk
            $table->integer('total_usage')->default(0);    // Total kumulatif pemakaian
            $table->integer('current_stock')->default(0);  // Sisa stok saat ini (Final)

            $table->integer('min_stock');    // Batas minimal untuk alert
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_reagents');
    }
};
