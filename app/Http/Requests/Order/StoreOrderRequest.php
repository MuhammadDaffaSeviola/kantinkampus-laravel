<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'canteen_id' => [
                'required',
                'integer',
                'exists:canteens,id',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.menu_id' => [
                'required',
                'integer',
                'exists:menus,id',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.note' => [
                'nullable',
                'string',
            ],

            'items.*.option_ids' => [
                'nullable',
                'array',
            ],

            'items.*.option_ids.*' => [
                'integer',
                'exists:menu_options,id',
            ],
        ];
    }
}
