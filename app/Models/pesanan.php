<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    /** @use HasFactory<\Database\Factories\PesananFactory> */
    use HasFactory;
    protected $table = 'pesanans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'kode_pesanan',
        'tgl_pesan',
        'total',
        'status',
    ];
    public function details()
    {
        return $this->hasMany(Detail::class, 'pesanan_id');
    }
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    // public function menus()
    // {
    //     return $this->belongsToMany(Menu::class, 'details', 'pesanan_id', 'menu_id');
    // }
}
