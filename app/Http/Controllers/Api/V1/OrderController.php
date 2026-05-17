<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => ['required', 'exists:events,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.ticket_type_id' => ['required', 'exists:ticket_types,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'payment_method' => ['nullable', 'in:manual,qris,bank_transfer,ewallet'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = auth('api')->user();

        try {
            $order = DB::transaction(function () use ($request, $user) {
                $totalAmount = 0;
                $preparedItems = [];

                foreach ($request->items as $item) {
                    $ticketType = TicketType::where('id', $item['ticket_type_id'])
                        ->where('event_id', $request->event_id)
                        ->where('is_active', true)
                        ->lockForUpdate()
                        ->first();

                    if (!$ticketType) {
                        throw new \Exception('Tipe tiket tidak valid untuk event ini.');
                    }

                    $availableQuota = $ticketType->quota - $ticketType->sold;

                    if ($item['quantity'] > $availableQuota) {
                        throw new \Exception('Kuota tiket ' . $ticketType->name . ' tidak mencukupi.');
                    }

                    $subtotal = $ticketType->price * $item['quantity'];
                    $totalAmount += $subtotal;

                    $preparedItems[] = [
                        'ticket_type' => $ticketType,
                        'quantity' => $item['quantity'],
                        'unit_price' => $ticketType->price,
                        'subtotal' => $subtotal,
                    ];
                }

                $order = Order::create([
                    'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5)),
                    'user_id' => $user->id,
                    'event_id' => $request->event_id,
                    'total_amount' => $totalAmount,
                    'payment_status' => 'pending',
                    'payment_method' => $request->payment_method ?? 'manual',
                ]);

                foreach ($preparedItems as $preparedItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'ticket_type_id' => $preparedItem['ticket_type']->id,
                        'quantity' => $preparedItem['quantity'],
                        'unit_price' => $preparedItem['unit_price'],
                        'subtotal' => $preparedItem['subtotal'],
                    ]);
                }

                return $order;
            });

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat. Silakan lanjutkan pembayaran.',
                'data' => [
                    'order' => $order->load(['event', 'items.ticketType']),
                ],
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        $user = auth('api')->user();

        $order = Order::with(['event', 'items.ticketType', 'tickets'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail order berhasil diambil.',
            'data' => [
                'order' => $order,
            ],
        ]);
    }

    public function pay($id)
    {
        $user = auth('api')->user();

        $order = Order::with(['items.ticketType'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan.',
            ], 404);
        }

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Order ini sudah dibayar.',
            ], 400);
        }

        try {
            DB::transaction(function () use ($order, $user) {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);

                foreach ($order->items as $item) {
                    $ticketType = TicketType::where('id', $item->ticket_type_id)
                        ->lockForUpdate()
                        ->first();

                    $availableQuota = $ticketType->quota - $ticketType->sold;

                    if ($item->quantity > $availableQuota) {
                        throw new \Exception('Kuota tiket tidak mencukupi saat pembayaran.');
                    }

                    $ticketType->increment('sold', $item->quantity);

                    for ($i = 1; $i <= $item->quantity; $i++) {
                        $ticketCode = 'VOK-' . now()->format('Y') . '-' . strtoupper(Str::random(8));

                        $payload = [
                            'ticket_code' => $ticketCode,
                            'order_id' => $order->id,
                            'event_id' => $order->event_id,
                            'user_id' => $user->id,
                            'signature' => hash_hmac('sha256', $ticketCode . '|' . $order->id, config('app.key')),
                        ];

                        Ticket::create([
                            'user_id' => $user->id,
                            'event_id' => $order->event_id,
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'ticket_type_id' => $item->ticket_type_id,
                            'ticket_code' => $ticketCode,
                            'qr_payload' => json_encode($payload),
                            'status' => 'active',
                        ]);
                    }
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil. Tiket QR berhasil dibuat.',
                'data' => [
                    'order' => $order->fresh()->load(['event', 'items.ticketType', 'tickets']),
                ],
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}