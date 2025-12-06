<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // --- PENGATURAN PENTING (WAJIB ADA) ---

    // 1. Sesuaikan nama tabel (Default Laravel: 'users', Database Anda: 'user')
    protected $table = 'user';

    // 2. Sesuaikan Primary Key (Default Laravel: 'id', Database Anda: 'Id_User')
    protected $primaryKey = 'Id_User';

    // 3. Matikan Timestamps (Default Laravel: True)
    // Karena tabel 'user' di screenshot Anda tidak punya kolom 'created_at' dan 'updated_at'
    // Jika ini True, aplikasi akan error saat mencoba update data login.
    public $timestamps = false;

    // ----------------------------------------

    protected $fillable = [
        'Nama',      // Sesuaikan dengan kolom DB
        'Username',  // Sesuaikan dengan kolom DB
        'Password',  // Sesuaikan dengan kolom DB
        'Role',      // Sesuaikan dengan kolom DB
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    // Override password agar Laravel tahu kolom password Anda bernama 'Password' (Huruf Besar)
    public function getAuthPassword()
    {
        return $this->Password;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'Password' => 'hashed',
        ];
    }
}