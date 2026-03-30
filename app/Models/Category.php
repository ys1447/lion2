<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function variants(){
        return $this->hasMany(Variant::class);
    }

    public function machines(){
        return $this->hasMany(Machine::class);
    }

    public function inputDatas()
    {
        return $this->hasManyThrough(InputData::class, Machine::class);
    }

    public function fillings(){
        return $this->hasMany(Filling::class);
    }
}
