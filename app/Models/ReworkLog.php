<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReworkLog extends Model
{
    protected $fillable = [
        'input_data_id',
        'initial_quantity',
        'current_quantity',
        'status'
    ];

    public function inputData()
    {
        return $this->belongsTo(InputData::class);
    }

    public function details()
    {
        return $this->hasMany(ReworkDetail::class, 'rework_log_id')->latest();
    }
}
