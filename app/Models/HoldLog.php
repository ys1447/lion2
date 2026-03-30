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

    public function scopeSearch($query, $term)
    {
        if (empty($term)) return $query;

        return $query->where(function ($q) use ($term) {
            // 1. Cari di kolom milik HoldLog sendiri
            $q->where('status', 'like', "%{$term}%")
                ->orWhere('notes', 'like', "%{$term}%");

            // 2. Cari di kolom milik InputData (Relasi)
            $q->orWhereHas('inputData', function ($queryInput) use ($term) {
                $queryInput->where('batch', 'like', "%{$term}%")
                    ->orWhere('notes', 'like', "%{$term}%");

                // 3. Cari di kolom milik Variant (Relasi dari InputData)
                $queryInput->orWhereHas('variant', function ($queryVariant) use ($term) {
                    $queryVariant->where('name', 'like', "%{$term}%");
                });
            });

            // 4. Cari berdasarkan nama User yang men-hold
            $q->orWhereHas('user', function ($queryUser) use ($term) {
                $queryUser->where('name', 'like', "%{$term}%");
            });
        });
    }

    public function scopeWithInputStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            // Kita "masuk" ke relasi inputData
            return $q->whereHas('inputData', function ($queryInput) use ($status) {
                // Kita filter kolom 'status' milik tabel input_data
                $queryInput->where('status', $status);
            });
        });
    }
}
