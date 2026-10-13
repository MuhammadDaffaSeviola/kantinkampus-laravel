<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'nim',
    'name',
    'email',
    'password_hash',
    'role',
    'faculty',
    'balance',
])]

#[Hidden([
    'password_hash',
    'remember_token',
])]

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom password yang digunakan Laravel Authentication.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    /**
     * Relasi User -> Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'password_hash' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}