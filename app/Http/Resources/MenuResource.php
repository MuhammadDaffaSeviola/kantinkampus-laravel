<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'canteen_id' => $this->canteen_id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image_url' => $this->image_url,
            'rating' => $this->rating,
            'is_available' => $this->is_available,

            'canteen' => new CanteenResource(
                $this->whenLoaded('canteen')
            ),

            'category' => new CategoryResource(
                $this->whenLoaded('category')
            ),

            'options' => MenuOptionResource::collection(
                $this->whenLoaded('options')
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}