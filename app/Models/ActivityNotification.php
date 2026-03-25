<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityNotification extends Model
{
    protected $fillable = ['user_name', 'action', 'target', 'details'];
}
