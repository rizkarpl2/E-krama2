<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_dokumen extends Model
{
    // Nama tabel yang sesuai dengan model ini
    protected $table = 'm_dokumens';
    // Nama kolom primary key yang sesuai dengan tabel
    protected $primaryKey = 'id_dokumen';
    // Daftar atribut yang dapat diisi (fillable) pada tabel 
    protected $fillable = [
        'nm_dokumen',
        'tgl_input',
        'penulis',
        'ket',
        'file',
    ];

    // Daftar atribut yang dianggap sebagai tipe data tanggal (timestamps)
    public $timestamps = true;    
}


