<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Nama Tabel (Wajib karena tidak standar 'users')
    protected $table = 'user';

    // 2. Primary Key (Wajib karena tidak standar 'id')
    protected $primaryKey = 'Id_User';
    
    // Pastikan tipe datanya benar
    public $incrementing = true;
    protected $keyType = 'int';

    // 3. Matikan Timestamps (Karena tabel tidak punya created_at/updated_at)
    public $timestamps = false;

    // 4. Kolom yang boleh diisi
    protected $fillable = [
        'Nama',
        'Username',
        'Password',
        'Role',
    ];

    // 5. Kolom yang disembunyikan
    protected $hidden = [
        'Password',
        'remember_token',
    ];

    // 6. Override Password (Wajib karena kolomnya 'Password' huruf besar)
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