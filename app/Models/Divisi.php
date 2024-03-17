<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = 'divisis';
    protected $primaryKey = 'id_divisi';
    protected $fillable = [
        'nm_divisi',
        'id_jabatan',
    ];

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }
}
