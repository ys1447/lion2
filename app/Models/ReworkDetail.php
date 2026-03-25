<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReworkDetail extends Model
{
    protected $fillable = [
        'rework_log_id',
        'quantity_used',
        'target_batch_number',
        'shift',
        'notes'
    ];

    /**
     * Relasi Balik ke Induk
     */
    public function reworkLog()
    {
        return $this->belongsTo(ReworkLog::class, 'rework_log_id');
    }
}
