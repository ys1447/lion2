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

    public function scopeSearch($query, $term)
    {
        if (empty($term)) return $query;

        return $query->where(function ($q) use ($term) {
            // 1. Cari di kolom internal ReworkLog
            $q->where('status', 'like', "%{$term}%")
                ->orWhere('initial_quantity', 'like', "%{$term}%")
                ->orWhere('current_quantity', 'like', "%{$term}%");

            // 2. Tembus ke InputData (untuk mencari Nama Variant & Batch)
            $q->orWhereHas('inputData', function ($queryInput) use ($term) {
                $queryInput->where('batch', 'like', "%{$term}%")
                    // Tembus lagi ke Variant dari InputData
                    ->orWhereHas('variant', function ($queryVariant) use ($term) {
                        $queryVariant->where('name', 'like', "%{$term}%");
                    });
            });

            // 3. (Opsional) Tembus ke ReworkDetail jika user mencari berdasarkan catatan remix
            $q->orWhereHas('details', function ($queryDetail) use ($term) {
                $queryDetail->where('notes', 'like', "%{$term}%")
                    ->orWhere('remix_batch_target', 'like', "%{$term}%");
            });
        });
    }

    public function scopeWithStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            // Karena nilai dari <option> akan kita samakan dengan database
            return $q->where('status', $status);
        });
    }
}
