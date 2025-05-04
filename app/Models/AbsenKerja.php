<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenKerja extends Model
{
    /** @use HasFactory<\Database\Factories\AbsenKerjaFactory> */
    use HasFactory;

    protected $table = 'tbl_absen_kerja';

    protected $primaryKey = 'id';

    protected $fillable = [
        // 'kode_absen' 
        'user_id',
        'tgl_absen',
        'jam_masuk',
        'jam_keluar',
        'status'
    ];

    protected $casts = [
        'jam_keluar' => 'datetime:H:i:s', // kalau kamu mau formatin otomatis
        // status biarin default, atau tambahin string
        'status' => 'string',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
