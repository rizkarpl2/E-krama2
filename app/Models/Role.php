<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'role_name'
    ];


    public function users()
    {
        return $this->hasMany(User::class, 'role_id'); // Jika 'role_id' bukan nama kunci asing yang diharapkan, tambahkan argumen kedua
    }
}
?>