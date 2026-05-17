<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function myTickets()
    {
        $user = auth('api')->user();

        $tickets = Ticket::with(['event', 'ticketType', 'order'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar tiket berhasil diambil.',
            'data' => [
                'tickets' => $tickets,
            ],
        ]);
    }

    public function show($ticketCode)
    {
        $user = auth('api')->user();

        $ticket = Ticket::with(['event.category', 'ticketType', 'order'])
            ->where('ticket_code', $ticketCode)
            ->where('user_id', $user->id)
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail tiket berhasil diambil.',
            'data' => [
                'ticket' => $ticket,
                'qr_payload' => json_decode($ticket->qr_payload, true),
            ],
        ]);
    }
}