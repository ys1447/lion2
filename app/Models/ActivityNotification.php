<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityNotification extends Model
{
    protected $fillable = ['user_name', 'action', 'target', 'details', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $term)
    {
        if (empty($term)) return $query;

        return $query->where(function ($q) use ($term) {
            // 1. Cari di kolom internal
            $q->where('action', 'like', "%{$term}%")
                ->orWhere('target', 'like', "%{$term}%")
                ->orWhere('details', 'like', "%{$term}%")
                ->orWhere('created_at', 'like', "%{$term}%");

            // 2. Tembus ke relasi User (Pindahkan ke DALAM fungsi ini)
            $q->orWhereHas('user', function ($queryUser) use ($term) {
                $queryUser->where('name', 'like', "%{$term}%");
            });

            // 3. Tambahan: Jika kamu punya kolom 'user_name' (string) di tabel ini, cari juga di sana
            $q->orWhere('user_name', 'like', "%{$term}%");
        }); // <--- Pastikan kurung tutup grup utama ada di sini
    }
}
