<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'canteen_id',
        'category_id',
        'name',
        'description',
        'price',
        'image_url',
        'rating',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'rating' => 'decimal:1',
            'is_available' => 'boolean',
        ];
    }

    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function options()
    {
        return $this->hasMany(MenuOption::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}