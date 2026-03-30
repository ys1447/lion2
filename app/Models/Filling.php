<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filling extends Model
{
    protected $fillable = ['user_id', 'category_id', 'title', 'issues', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $term)
    {
        // Jika term kosong, langsung return query asli agar tidak berat
        if (empty($term)) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")

                // Mencari berdasarkan nama User di tabel users
                ->orWhereHas('user', function ($subQuery) use ($term) {
                    $subQuery->where('name', 'like', "%{$term}%");
                })

                // Mencari berdasarkan nama Category di tabel categories
                ->orWhereHas('category', function ($subQuery) use ($term) {
                    $subQuery->where('name', 'like', "%{$term}%");
                })
                ->orWhere('issues', 'like', "%{$term}%");
        });
    }

    public function scopeWithStatus($query, $value)
    {
        // Kita gunakan !== '' karena jika value adalah "0" (Inactive), 
        // empty() akan menganggapnya kosong.
        return $query->when($value !== '', function ($q) use ($value) {
            return $q->where('status', $value);
        });
    }
}
