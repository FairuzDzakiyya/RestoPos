<?php

use App\Models\LogActivity;

if (!function_exists('logActivity')) {
    function logActivity($action, $description = null)
    {
        logger('logActivity helper terpanggil!'); // <-- pindahin ke sini
        LogActivity::create([
            'user' => auth()->check() ? auth()->user()->name : 'Guest',
            'action' => $action,
            'description' => $description,
        ]);
    }
}
