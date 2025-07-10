<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $fillable = [
        'name', 'email', 'password','phone','email','role','status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role_display()
    {
        return match($this->role) {
            1 => 'Admin',
            2 => 'Petugas Registrasi',
            3 => 'Dokter',
            4 => 'Petugas Obat',
            default => 'Tidak Diketahui',
        };
    }
}
