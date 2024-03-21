<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggotas';
    protected $primaryKey = 'id_anggota';
    protected $fillable = [
        'nm_anggota',
        'email',
        'alamat',
        'no_tlp',
        'tgl_lahir',
        'tgl_bergabung',
        'id_divisi',
        'id_jabatan',
    ];
}
