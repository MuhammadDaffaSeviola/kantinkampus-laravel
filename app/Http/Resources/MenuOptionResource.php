<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuOptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'menu_id' => $this->menu_id,
            'option_group' => $this->option_group,
            'option_name' => $this->option_name,
            'additional_price' => $this->additional_price,
            'is_available' => $this->is_available,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
