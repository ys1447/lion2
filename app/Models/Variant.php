<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = ['name', 'slug', 'category_id', 'capacity'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inputDatas()
    {
        return $this->hasMany(InputData::class);
    }

    public function jobMixings()
    {
        return $this->hasMany(Variant::class);
    }

    // Variant.php
    public function standards()
    {
        return $this->hasMany(VariantStandard::class, 'variant_id', 'id');
    }
}
