<?php

use App\Models\LogActivity;
use Illuminate\Support\Facades\Log;

if (!function_exists('logActivity')) {
    function logActivity($action, $description = null)
    {
        $user = auth()->check() ? auth()->user()->name : 'Guest';
        $ip = request()->ip();

        // Simpan ke file log Laravel
        Log::info('LogActivity helper terpanggil!', [
            'user' => $user,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ip,
        ]);

        // Simpan ke tabel logs
        LogActivity::create([
            'user' => $user,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ip,
        ]);
    }
}
