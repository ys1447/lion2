<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoldLog extends Model
{
    protected $casts = [
        'hold_at' => 'datetime',
        'released_at' => 'datetime',
    ];
    
    protected $guarded = [];

    public function inputData()
    {
        return $this->belongsTo(InputData::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
