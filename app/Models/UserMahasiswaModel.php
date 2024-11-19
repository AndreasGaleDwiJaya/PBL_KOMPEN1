<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi class Authenticatable
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserMahasiswaModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    use HasFactory;

    protected $table = 'm_usermahasiswa';    //table yang akan digunakan
    protected $primaryKey = 'mahasiswa_id'; //primary key dari table

    protected $fillable = ['level_id', 'username', 'nama', 'password', 'nim', 'email', 'avatar','created_at', 'updated_at'];

   protected $hidden = ['password']; //jangan ditampilkan saat select

   protected $casts = ['password' => 'hashed'];  //casting password agar otomatis di hash
   
   //relasi ke tabel level
    public function level(): BelongsTo {

        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // mendapatkan nama role
    public function getRoleName():string {
        return $this->level->level_nama;
    }

    //cek apakah user memiliki role tertentu
    public function hasRole($role):bool {
        return $this->level->level_kode == $role;
    }

    public function getRole(){
        return $this->level->level_kode;
    }

}