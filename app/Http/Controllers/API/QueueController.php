<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\QueueTicketResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function show(Request $request, int $orderId): JsonResponse
    {
        $order = Order::query()
            ->where('id', $orderId)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $queueTicket = $order->queueTicket;

        if (!$queueTicket) {
            return response()->json([
                'status' => 'success',
                'message' => 'Nomor antrean belum tersedia',
                'data' => null,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data antrean berhasil diambil',
            'data' => new QueueTicketResource($queueTicket),
        ]);
    }
}