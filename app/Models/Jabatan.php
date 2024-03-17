<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatans';
    protected $primaryKey = 'id_jabatan';
    protected $fillable = [
        'jenis_jabatan',
    ];
    public $timestamps = true;  
}

