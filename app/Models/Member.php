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

    public function detail()
    {
        return $this->hasMany(detail::class, 'member_id', 'id');
    }
}
