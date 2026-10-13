<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canteen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'building',
        'status',
        'queue_density',
        'estimated_wait_minutes',
    ];

    protected function casts(): array
    {
        return [
            'queue_density' => 'integer',
            'estimated_wait_minutes' => 'integer',
        ];
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}