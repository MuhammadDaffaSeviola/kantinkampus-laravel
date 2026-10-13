<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'option_group',
        'option_name',
        'additional_price',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'additional_price' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function orderItemOptions()
    {
        return $this->hasMany(OrderItemOption::class);
    }
}