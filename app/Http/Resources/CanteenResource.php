<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CanteenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'building' => $this->building,
            'status' => $this->status,
            'queue_density' => $this->queue_density,
            'estimated_wait_minutes' => $this->estimated_wait_minutes,

            'menus' => MenuResource::collection(
                $this->whenLoaded('menus')
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
