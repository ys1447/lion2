<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class JobMixing extends Model
{
    protected $fillable = ['job_mixing_id', 'variant_id', 'name', 'type', 'code_job_mixing', 'capacity', 'no_document', 'no_ftd', 'no_revisi', 'is_active'];

    public function inputDatas()
    {
        return $this->hasMany(InputData::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    /**
     * Scope untuk pencarian Job Mixing secara menyeluruh
     */
    public function scopeSearch($query, $term)
    {
        // Jika term kosong, langsung return query asli agar tidak berat
        if (empty($term)) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('code_job_mixing', 'like', "%{$term}%")
                ->orWhere('no_document', 'like', "%{$term}%")
                ->orWhere('no_ftd', 'like', "%{$term}%")
                ->orWhere('no_revisi', 'like', "%{$term}%")
                ->orWhere('capacity', 'like', "%{$term}%");

            // Logika tambahan untuk 'type' 
            // Misal jika user ngetik "Trial" dan type true = Trial
            if (stripos('trial', $term) !== false) {
                $q->orWhere('type', true);
            } elseif (stripos('reguler', $term) !== false) {
                $q->orWhere('type', false);
            }
        });
    }
}
