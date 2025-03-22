<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;




    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'menus';
    protected $fillable = ['kategori_id', 'menu', 'deskripsi', 'harga', 'stok', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}