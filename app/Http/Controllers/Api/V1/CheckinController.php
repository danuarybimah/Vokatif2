<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckinController extends Controller
{
    public function validateTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_code' => ['required_without:qr_payload', 'string'],
            'qr_payload' => ['required_without:ticket_code'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ticketCode = $request->ticket_code;

        if (!$ticketCode && $request->qr_payload) {
            $payload = is_array($request->qr_payload)
                ? $request->qr_payload
                : json_decode($request->qr_payload, true);

            $ticketCode = $payload['ticket_code'] ?? null;
        }

        $scanner = auth('api')->user();

        $ticket = Ticket::with(['event', 'user', 'ticketType'])
            ->where('ticket_code', $ticketCode)
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan atau QR tidak valid.',
            ], 404);
        }

        if ($ticket->status === 'used') {
            Checkin::create([
                'ticket_id' => $ticket->id,
                'event_id' => $ticket->event_id,
                'checked_by' => $scanner->id,
                'status' => 'failed',
                'notes' => 'Tiket sudah pernah digunakan.',
                'checked_at' => now(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah pernah digunakan.',
                'data' => [
                    'ticket' => $ticket,
                    'checked_in_at' => $ticket->checked_in_at,
                ],
            ], 409);
        }

        if ($ticket->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak aktif.',
            ], 400);
        }

        DB::transaction(function () use ($ticket, $scanner, $request) {
            $ticket->update([
                'status' => 'used',
                'checked_in_at' => now(),
            ]);

            Checkin::create([
                'ticket_id' => $ticket->id,
                'event_id' => $ticket->event_id,
                'checked_by' => $scanner->id,
                'status' => 'success',
                'notes' => $request->notes ?? 'Check-in berhasil.',
                'checked_at' => now(),
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil. Tiket valid.',
            'data' => [
                'ticket' => $ticket->fresh()->load(['event', 'user', 'ticketType']),
            ],
        ]);
    }

    public function history()
    {
        $checkins = Checkin::with(['ticket.user', 'ticket.ticketType', 'event', 'scanner'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat check-in berhasil diambil.',
            'data' => [
                'checkins' => $checkins,
            ],
        ]);
    }
}