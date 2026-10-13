<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'queue_number',
        'queue_status',
        'estimated_wait_minutes',
        'people_ahead',
    ];

    protected function casts(): array
    {
        return [
            'estimated_wait_minutes' => 'integer',
            'people_ahead' => 'integer',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}