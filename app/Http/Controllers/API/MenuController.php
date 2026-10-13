<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        $menus = Menu::query()
            ->with(['canteen', 'category'])
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data menu berhasil diambil',
            'data' => $menus,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $menu = Menu::with([
            'canteen',
            'category',
            'options',
        ])->find($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail menu berhasil diambil',
            'data' => $menu,
        ]);
    }
}