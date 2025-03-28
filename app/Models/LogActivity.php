<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'user', 'action', 'description', 'ip_address'
    ];
}
