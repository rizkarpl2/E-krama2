<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;



class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'id_divisi'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    //menyembunyikan kolum yg bersifat sensitif
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
       /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    // public function role(){
    //     return $this->belongsTo(Role::class);
    // }



    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // Jika 'role_id' bukan nama kunci asing yang diharapkan, tambahkan argumen kedua
    }

    public function kas_masuk()
    {
        return $this->hasMany(KasMasuk::class, 'id_kasmasuk'); // Jika 'role_id' bukan nama kunci asing yang diharapkan, tambahkan argumen kedua
    }

    public function kas_keluar()
    {
        return $this->hasMany(KasKeluar::class, 'id_kaskeluar'); // Jika 'role_id' bukan nama kunci asing yang diharapkan, tambahkan argumen kedua
    }

    public function divisi() // menambahkan relasi dengan Divisi
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }


}
