<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReagent extends Model
{
    protected $fillable = [
        'name',
        'initial_stock',
        'total_incoming',
        'total_usage',
        'current_stock',
        'min_stock',
        'empty_bottle_weight'
    ];

    /**
     * Boot function untuk menghitung current_stock secara otomatis
     * sebelum data disimpan ke database.
     */
    protected static function booted()
    {
        static::saving(function ($reagent) {
            // Rumus: (Awal + Masuk) - Pakai
            $reagent->current_stock = ($reagent->initial_stock + $reagent->total_incoming) - $reagent->total_usage;
        });
    }

    public function logs()
    {
        // Satu reagent punya banyak catatan log
        return $this->hasMany(ReagentLog::class, 'stock_reagent_id');
    }
}
