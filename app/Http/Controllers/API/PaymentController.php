<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Models\Payment;
use App\Models\QueueTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
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

        $payment = $order->payment;

        if (!$payment) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data pembayaran belum tersedia',
                'data' => null,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data pembayaran berhasil diambil',
            'data' => new PaymentResource($payment),
        ]);
    }

    public function store(StorePaymentRequest $request, int $orderId): JsonResponse
    {
        $validated = $request->validated();

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

        if ($order->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak dapat dibayar pada status saat ini',
                'data' => null,
            ], 422);
        }

        if ($order->payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran untuk pesanan ini sudah tersedia',
                'data' => new PaymentResource($order->payment),
            ], 409);
        }

       $payment = DB::transaction(function () use ($order, $validated) {

    $payment = Payment::create([
        'order_id' => $order->id,
        'payment_method' => $validated['payment_method'],
        'amount' => $order->total_amount,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $order->update([
        'status' => 'paid',
    ]);

    // Buat nomor antrean otomatis setelah pembayaran berhasil.
    $lastQueue = QueueTicket::query()
        ->orderByDesc('id')
        ->lockForUpdate()
        ->first();

    $nextNumber = $lastQueue
        ? ((int) substr($lastQueue->queue_number, 1)) + 1
        : 1;

    QueueTicket::create([
        'order_id' => $order->id,
        'queue_number' => 'A' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT),
        'queue_status' => 'waiting',
        'estimated_wait_minutes' => 10,
        'people_ahead' => $lastQueue ? 1 : 0,
    ]);

    return $payment;
});

        return response()->json([
    'status' => 'success',
    'message' => 'Pembayaran berhasil diproses',
    'data' => new PaymentResource($payment),
], 201);
    }
}