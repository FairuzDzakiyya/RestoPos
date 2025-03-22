<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $table = 'members';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_member',
        'nama_member',
        'alamat',
        'telp',
        'email',
    ];
}
