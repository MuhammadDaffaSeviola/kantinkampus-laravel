<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->with([
                'canteen',
                'items.menu',
                'items.options.menuOption',
                'payment',
                'queueTicket',
            ])
            ->latest('ordered_at')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pesanan berhasil diambil',
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function store(StoreOrderRequest $request): JsonResponse
{
    $validated = $request->validated();

    $order = DB::transaction(function () use ($request, $validated) {

        $subtotal = 0;

        $order = Order::create([
            'user_id' => $request->user()->id,
            'canteen_id' => $validated['canteen_id'],
            'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
            'subtotal' => 0,
            'service_fee' => 0,
            'discount' => 0,
            'total_amount' => 0,
            'status' => 'pending',
            'ordered_at' => now(),
        ]);

        foreach ($validated['items'] as $itemData) {

            $menu = Menu::with('options')
                ->findOrFail($itemData['menu_id']);

            // Pastikan menu memang berasal dari kantin yang dipilih
            if ((int) $menu->canteen_id !== (int) $validated['canteen_id']) {
                abort(422, 'Menu tidak tersedia di kantin yang dipilih.');
            }

            if (!$menu->is_available) {
                abort(422, "Menu {$menu->name} sedang tidak tersedia.");
            }

            $quantity = $itemData['quantity'];

            // Harga dasar menu
            $unitPrice = (float) $menu->price;

            // Harga opsi
            $optionTotal = 0;
            $selectedOptions = [];

            foreach ($itemData['option_ids'] ?? [] as $optionId) {

                $option = $menu->options
                    ->firstWhere('id', $optionId);

                if (!$option) {
                    abort(
                        422,
                        "Opsi menu tidak valid untuk {$menu->name}."
                    );
                }

                if (!$option->is_available) {
                    abort(
                        422,
                        "Opsi {$option->option_name} sedang tidak tersedia."
                    );
                }

                $additionalPrice = (float) $option->additional_price;

                $optionTotal += $additionalPrice;

                $selectedOptions[] = [
                    'menu_option_id' => $option->id,
                    'additional_price' => $additionalPrice,
                ];
            }

            // Harga per unit termasuk opsi
            $itemUnitPrice = $unitPrice + $optionTotal;

            // Subtotal item
            $itemSubtotal = $itemUnitPrice * $quantity;

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'quantity' => $quantity,
                'unit_price' => $itemUnitPrice,
                'subtotal' => $itemSubtotal,
                'note' => $itemData['note'] ?? null,
            ]);

            foreach ($selectedOptions as $selectedOption) {
                $orderItem->options()->create($selectedOption);
            }

            $subtotal += $itemSubtotal;
        }

        // Untuk tahap API ini service fee dan discount belum dihitung otomatis.
        $serviceFee = 0;
        $discount = 0;
        $totalAmount = $subtotal + $serviceFee - $discount;

        $order->update([
            'subtotal' => $subtotal,
            'service_fee' => $serviceFee,
            'discount' => $discount,
            'total_amount' => $totalAmount,
        ]);

        return $order;
    });

    $order->load([
        'canteen',
        'items.menu',
        'items.options.menuOption',
        'payment',
        'queueTicket',
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Pesanan berhasil dibuat',
        'data' => new OrderResource($order),
    ], 201);
}

    public function show(Request $request, int $id): JsonResponse
    {
        $order = Order::query()
            ->where('user_id', $request->user()->id)
            ->with([
                'canteen',
                'items.menu',
                'items.options.menuOption',
                'payment',
                'queueTicket',
            ])
            ->find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail pesanan berhasil diambil',
            'data' => new OrderResource($order),
        ]);
    }
    public function updateStatus(
    Request $request,
    int $id
): JsonResponse {
    $validated = $request->validate([
        'status' => [
            'required',
            'string',
            'in:pending,paid,processing,ready,completed,cancelled',
        ],
    ]);

    $order = Order::query()
        ->where('id', $id)
        ->where('user_id', $request->user()->id)
        ->first();

    if (!$order) {
        return response()->json([
            'status' => 'error',
            'message' => 'Pesanan tidak ditemukan',
            'data' => null,
        ], 404);
    }

    $currentStatus = $order->status;
    $newStatus = $validated['status'];

    // Status final tidak dapat diubah lagi.
    if (in_array($currentStatus, ['completed', 'cancelled'])) {
        return response()->json([
            'status' => 'error',
            'message' => 'Status pesanan sudah final dan tidak dapat diubah',
            'data' => null,
        ], 422);
    }

    // Status yang diizinkan.
    $allowedTransitions = [
        'pending' => ['paid', 'cancelled'],
        'paid' => ['processing'],
        'processing' => ['ready'],
        'ready' => ['completed'],
    ];

    if (
        !isset($allowedTransitions[$currentStatus]) ||
        !in_array($newStatus, $allowedTransitions[$currentStatus])
    ) {
        return response()->json([
            'status' => 'error',
            'message' => "Perubahan status dari {$currentStatus} ke {$newStatus} tidak diperbolehkan",
            'data' => null,
        ], 422);
    }

    // Status paid hanya boleh jika pembayaran sudah ada.
    if ($newStatus === 'paid' && !$order->payment) {
        return response()->json([
            'status' => 'error',
            'message' => 'Pesanan belum memiliki pembayaran',
            'data' => null,
        ], 422);
    }

    $order->update([
        'status' => $newStatus,
    ]);

    $order->load([
        'canteen',
        'items.menu',
        'items.options.menuOption',
        'payment',
        'queueTicket',
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Status pesanan berhasil diperbarui',
        'data' => new OrderResource($order),
    ]);
}

}