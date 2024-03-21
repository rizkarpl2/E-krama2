<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasMasuk extends Model
{
    // Nama tabel yang sesuai dengan model ini
    protected $table = 'kas_masuks';
    // Nama kolom primary key yang sesuai dengan tabel
    protected $primaryKey = 'id_kasmasuk';
    // Daftar atribut yang dapat diisi (fillable) pada tabel 
    protected $fillable = [
        'nm_pj',
        'tgl_input',
        'nominal',
        'ket',
        
        
    ];

    // Daftar atribut yang dianggap sebagai tipe data tanggal (timestamps)
    public $timestamps = true;  
}
