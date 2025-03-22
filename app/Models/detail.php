<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail extends Model
{
    /** @use HasFactory<\Database\Factories\DetailFactory> */
    use HasFactory;

    protected $table = 'details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'menu_id',
        'pesanan_id',
        'qty',
        'harga',
        'subtotal',
    ];

    public function menu()
    {
        return $this->belongsTo(menu::class, 'menu_id', 'id');
    }
    public function pesanan()
    {
        return $this->belongsTo(pesanan::class, 'pesanan_id', 'id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
