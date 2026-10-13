<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'canteen_id' => $this->canteen_id,
            'order_number' => $this->order_number,

            'subtotal' => $this->subtotal,
            'service_fee' => $this->service_fee,
            'discount' => $this->discount,
            'total_amount' => $this->total_amount,

            'status' => $this->status,
            'ordered_at' => $this->ordered_at,

            'canteen' => $this->whenLoaded('canteen'),

            'items' => OrderItemResource::collection(
                $this->whenLoaded('items')
            ),

            'payment' => new PaymentResource(
                $this->whenLoaded('payment')
            ),

            'queue_ticket' => new QueueTicketResource(
                $this->whenLoaded('queueTicket')
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}