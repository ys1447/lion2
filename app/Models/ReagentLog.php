<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReagentLog extends Model
{
    protected $guarded = [];

    public function reagent()
    {
        // Satu log hanya dimiliki oleh satu reagent
        return $this->belongsTo(StockReagent::class, 'stock_reagent_id');
    }
}
