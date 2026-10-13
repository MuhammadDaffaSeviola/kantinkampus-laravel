<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuOptionResource;
use App\Models\Menu;
use App\Models\MenuOption;
use Illuminate\Http\JsonResponse;

class MenuOptionController extends Controller
{
    public function index(int $menuId): JsonResponse
    {
        $menu = Menu::find($menuId);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $options = MenuOption::query()
            ->where('menu_id', $menuId)
            ->where('is_available', true)
            ->orderBy('option_group')
            ->orderBy('option_name')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data opsi menu berhasil diambil',
            'data' => MenuOptionResource::collection($options),
        ]);
    }
}