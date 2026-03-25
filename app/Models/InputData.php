<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputData extends Model
{
    protected $fillable = [
        'status',
        'user_id',
        'variant_id',
        'job_mixing_id',
        'machine_id',
        'batch',
        'job_number',



        'ph_1',
        'ph_2',
        'ph_3',
        'viscosity_1',
        'viscosity_2',
        'viscosity_3',

        'specific_gravity',
        'active_ingredient',
        'zpt',
        'soap_percentage',

        'rad',
        'rgx',
        'rxb',
        'ryc',

        'appearance',
        'odor',

        'capacity',
        'shift',
        'job_code',

        'co_job',

        'notes',
    ];

    // Di Model InputData.php
    public function getJobColorAttribute()
    {
        $code = $this->job_code ?? '';

        // Logika sederhana: tentukan warna berdasarkan sisa bagi (modulo)
        $colors = [
            'bg-yellow-100 text-yellow-800',
            'bg-blue-100 text-blue-800',
            'bg-green-100 text-green-800',
            'bg-purple-100 text-purple-800',
            'bg-pink-100 text-pink-800',
            'bg-orange-100 text-orange-800',
            'bg-indigo-100 text-indigo-800',
        ];

        // crc32 mengubah string jadi angka, abs() memastikan positif
        $index = abs(crc32($code)) % count($colors);

        return $colors[$index];
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function jobMixing()
    {
        return $this->belongsTo(JobMixing::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    // / Relasi ke semua jejak hold (satu batch bisa berkali-kali di-hold dalam sejarahnya)
    public function holdLogs()
    {
        return $this->hasMany(HoldLog::class);
    }

    // Untuk mendapatkan alasan hold yang masih aktif saat ini
    public function activeHold()
    {
        return $this->hasOne(HoldLog::class)->whereNull('released_at')->latestOfMany();
    }

    // 1. Relasi Umum (Semua riwayat rework untuk batch ini)
    public function reworkLogs()
    {
        return $this->hasMany(ReworkLog::class, 'input_data_id');
    }

    // 2. Relasi Khusus (Cek apakah batch ini SEDANG aktif di list rework)
    // Ini yang dipakai untuk menyembunyikan tombol di Blade
    public function activeRework()
    {
        return $this->hasOne(ReworkLog::class, 'input_data_id')->where('status', 'active');
    }
}
