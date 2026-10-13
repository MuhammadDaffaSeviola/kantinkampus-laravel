<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'queue_number' => $this->queue_number,
            'queue_status' => $this->queue_status,
            'estimated_wait_minutes' => $this->estimated_wait_minutes,
            'people_ahead' => $this->people_ahead,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}