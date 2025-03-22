<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    /** @use HasFactory<\Database\Factories\PengajuanFactory> */
    use HasFactory;
    protected $table = 'pengajuans';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_pengajuan',
        'member_id',
        'nama_barang',
        'tgl_pengajuan',
        'qty',
    ];
    protected $casts = [
        'terpenuhi' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
