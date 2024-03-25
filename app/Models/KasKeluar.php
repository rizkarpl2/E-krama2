<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKeluar extends Model
{
    // Nama tabel yang sesuai dengan model ini
    protected $table = 'kas_keluars';
    // Nama kolom primary key yang sesuai dengan tabel
    protected $primaryKey = 'id_kaskeluar';
    // Daftar atribut yang dapat diisi (fillable) pada tabel 
    protected $fillable = [
        'nm_pj_klr',
        'tgl_input',
        'nominal',
        'ket',
        'name',
        
    ];

    // Daftar atribut yang dianggap sebagai tipe data tanggal (timestamps)
    public $timestamps = true;  
}
