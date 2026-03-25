<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantConfig extends Model
{
    protected $fillable = ['variant_id', 'visible_columns'];

    // SANGAT PENTING: Cast JSON ke Array
    protected $casts = [
        'visible_columns' => 'array',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
