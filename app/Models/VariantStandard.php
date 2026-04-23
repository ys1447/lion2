<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantStandard extends Model
{
    protected $fillable = ['variant_id', 'field_name', 'min_value', 'max_value'];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
