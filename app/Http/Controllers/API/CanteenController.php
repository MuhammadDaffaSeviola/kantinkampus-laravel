<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CanteenResource;
use App\Models\Canteen;

class CanteenController extends Controller
{
    public function index()
    {
        $canteens = Canteen::query()
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data kantin berhasil diambil',
            'data' => CanteenResource::collection($canteens),
        ]);
    }

    public function show($id)
    {
        $canteen = Canteen::find($id);

        if (!$canteen) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kantin tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail kantin berhasil diambil',
            'data' => new CanteenResource($canteen),
        ]);
    }
}