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
}
