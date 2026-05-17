<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with([
                'category',
                'organizer:id,name,email',
                'ticketTypes'
            ])
            ->where('status', 'published')
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('city', 'like', '%' . $request->search . '%')
                    ->orWhere('location', 'like', '%' . $request->search . '%');
            })
            ->when($request->category, function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('slug', $request->category);
                });
            })
            ->when($request->city, function ($query) use ($request) {
                $query->where('city', $request->city);
            })
            ->when($request->featured, function ($query) {
                $query->where('is_featured', true);
            })
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar event berhasil diambil.',
            'data' => $events,
        ]);
    }

    public function show(string $slug)
    {
        $event = Event::with([
                'category',
                'organizer:id,name,email',
                'organizer.organizerProfile',
                'ticketTypes' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail event berhasil diambil.',
            'data' => [
                'event' => $event,
            ],
        ]);
    }
}