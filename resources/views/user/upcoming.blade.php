@extends('layouts.user')

@section('content')
<div class="space-y-8">

    <div>
        <h1 class="text-5xl font-black">Upcoming Events</h1>
        <p class="text-slate-400 mt-3">Event yang akan kamu hadiri.</p>
    </div>

    @php $role = auth()->user()?->role?->slug; @endphp
        <div class="mb-8">
            <a href="{{ $role === 'admin' ? '/admin/dashboard' : ($role === 'organizer' ? '/organizer/dashboard' : '/home') }}"
                class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke {{ $role === 'admin' ? 'Dashboard' : ($role === 'organizer' ? 'Dashboard' : 'Home') }}
            </a>
        </div>

    @forelse($tickets as $ticket)
        @php
            $event     = $ticket->event;
            $daysLeft  = now()->diffInDays($event->start_at, false);
        @endphp

        <div class="glass rounded-[32px] p-8 flex flex-col md:flex-row gap-8 items-center">

            <!-- GRADIENT IMAGE -->
            <div class="w-full md:w-48 h-40 rounded-2xl gradient-card flex-shrink-0 flex items-end p-4">
                <span class="text-xs font-bold bg-black/30 px-3 py-1 rounded-full backdrop-blur">
                    {{ $event->category->name ?? 'Event' }}
                </span>
            </div>

            <!-- INFO -->
            <div class="flex-1">

                <div class="flex items-center gap-3 mb-3">
                    @if($daysLeft > 0)
                        <span class="px-3 py-1 rounded-full bg-violet-500/20 text-violet-300 text-xs font-bold">
                            {{ $daysLeft }} hari lagi
                        </span>
                    @elseif($daysLeft === 0)
                        <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold animate-pulse">
                            HARI INI!
                        </span>
                    @endif

                    <span class="text-slate-400 text-sm">{{ $event->city }}</span>
                </div>

                <h2 class="text-3xl font-black">{{ $event->title }}</h2>

                <div class="mt-4 grid sm:grid-cols-3 gap-3">
                    <div class="glass rounded-xl p-3">
                        <p class="text-xs text-slate-400">Tanggal</p>
                        <p class="font-bold mt-1">{{ $event->start_at->format('d M Y') }}</p>
                    </div>
                    <div class="glass rounded-xl p-3">
                        <p class="text-xs text-slate-400">Waktu</p>
                        <p class="font-bold mt-1">{{ $event->start_at->format('H:i') }} WIB</p>
                    </div>
                    <div class="glass rounded-xl p-3">
                        <p class="text-xs text-slate-400">Tiket</p>
                        <p class="font-bold mt-1 text-cyan-400">{{ $ticket->ticketType->name }}</p>
                    </div>
                </div>

            </div>

            <!-- ACTIONS -->
            <div class="flex flex-col gap-3 flex-shrink-0">
                <a href="{{ route('tickets.show', $ticket->ticket_code) }}"
                   class="px-6 py-3 rounded-2xl bg-violet-600 hover:bg-violet-500 font-bold transition text-center">
                    Lihat QR
                </a>
                <a href="{{ route('events.show', $event->slug) }}"
                   class="px-6 py-3 rounded-2xl bg-white/10 hover:bg-white/15 font-bold transition text-center">
                    Detail Event
                </a>
            </div>

        </div>

    @empty
        <div class="glass rounded-[32px] p-16 text-center">
            <div class="w-20 h-20 rounded-full bg-violet-500/20 flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-black">Tidak ada event upcoming</h2>
            <p class="text-slate-400 mt-3">Beli tiket dulu untuk melihat event yang akan datang.</p>
            <a href="/events" class="inline-block mt-6 px-8 py-4 rounded-2xl bg-violet-600 hover:bg-violet-500 font-bold transition">
                Explore Events
            </a>
        </div>
    @endforelse

</div>
@endsection
