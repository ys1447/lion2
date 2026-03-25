<?php

namespace App\Traits;

use App\Models\ActivityNotification;
use Illuminate\Support\Facades\Auth;

trait HasNotification
{
    public function sendNotification($action, $target, $details)
    {
        ActivityNotification::create([
            'user_name' => Auth::user()->username ?? 'System', // Sesuaikan kolom user kamu
            'action'    => $action,
            'target'    => $target,
            'details'   => $details,
        ]);

        $this->dispatch('notification-updated');
    }
}