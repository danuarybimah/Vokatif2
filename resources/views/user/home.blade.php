@extends('layouts.user')

@section('content')
<div class="space-y-10">

        {{-- HERO --}}
        <div data-hero-section class="glass rounded-[32px] p-8 flex flex-col md:flex-row items-center justify-between gap-6"
            style="background: linear-gradient(135deg, rgba(124,58,237,0.2), rgba(6,182,212,0.1));">

        <div>
            <p class="text-slate-400 text-sm uppercase tracking-widest mb-2">Selamat datang kembali</p>
            <h1 class="text-5xl font-black">{{ $user->name }} </h1>
            <p class="text-slate-400 mt-3 text-lg">
                Kamu punya <span class="text-cyan-400 font-bold">{{ $totalTickets }} tiket</span>
                dan sudah belanja
                <span class="text-fuchsia-400 font-bold">Rp{{ number_format($totalSpent, 0, ',', '.') }}</span>
            </p>
        </div>

        <div class="flex gap-4 flex-wrap">
            <a href="/events"
               class="px-6 py-4 rounded-2xl bg-violet-600 hover:bg-violet-500 font-black transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Explore Events
            </a>
            <a href="/my-tickets"
               class="px-6 py-4 rounded-2xl glass hover:bg-white/10 font-black transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                My Tickets
            </a>
        </div>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <a data-stat-card data-hover-lift href="/my-tickets" class="glass rounded-2xl p-6 hover:bg-white/10 transition">
            <p class="text-slate-400 text-sm">Total Tiket</p>
            <h2 class="text-5xl font-black mt-3 text-cyan-400">{{ $totalTickets }}</h2>
        </a>
        <a data-stat-card data-hover-lift href="/transactions" class="glass rounded-2xl p-6 hover:bg-white/10 transition">
            <p class="text-slate-400 text-sm">Total Transaksi</p>
            <h2 class="text-5xl font-black mt-3">{{ $totalOrders }}</h2>
        </a>
        <a data-stat-card data-hover-lift href="/upcoming" class="glass rounded-2xl p-6 hover:bg-white/10 transition">
            <p class="text-slate-400 text-sm">Upcoming Events</p>
            <h2 class="text-5xl font-black mt-3 text-violet-400">{{ $upcomingTickets->count() }}</h2>
        </a>
        <a data-stat-card data-hover-lift href="/transactions" class="glass rounded-2xl p-6 hover:bg-white/10 transition">
            <p class="text-slate-400 text-sm">Total Belanja</p>
            <h2 class="text-2xl font-black mt-3 text-fuchsia-400">
                Rp{{ number_format($totalSpent, 0, ',', '.') }}
            </h2>
        </a>

    </div>

    {{-- UPCOMING EVENTS --}}
    @if($upcomingTickets->count() > 0)
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 data-section-title class="text-3xl font-black">Upcoming Events</h2>
                <p class="text-slate-400 mt-1">Event yang akan kamu hadiri.</p>
            </div>
            <a href="/upcoming" class="text-violet-400 font-bold hover:text-violet-300 transition">
                Lihat semua →
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($upcomingTickets as $ticket)
            @php $daysLeft = now()->diffInDays($ticket->event->start_at, false); @endphp
            <div data-scroll-card data-hover-lift class="glass rounded-3xl overflow-hidden hover:bg-white/[0.08] transition">

                <div class="h-40 gradient-card flex items-end p-5">
                    <span class="text-xs font-bold bg-black/30 px-3 py-1 rounded-full backdrop-blur">
                        {{ $ticket->event->category->name ?? 'Event' }}
                    </span>
                </div>

                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        @if($daysLeft === 0)
                            <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold animate-pulse">HARI INI</span>
                        @elseif($daysLeft > 0)
                            <span class="px-3 py-1 rounded-full bg-violet-500/20 text-violet-300 text-xs font-bold">{{ $daysLeft }} hari lagi</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-black">{{ $ticket->event->title }}</h3>
                    <p class="text-slate-400 text-sm mt-1">{{ $ticket->event->start_at->format('d M Y · H:i') }} WIB</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-cyan-400 font-bold text-sm">{{ $ticket->ticketType->name }}</span>
                        <a href="{{ route('tickets.show', $ticket->ticket_code) }}"
                           class="px-4 py-2 rounded-xl bg-violet-600/30 text-violet-300 hover:bg-violet-600/50 text-sm font-bold transition">
                            Lihat QR
                        </a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- QUICK MENU --}}
    <div>
        <h2 data-section-title class="text-3xl font-black mb-6">Menu Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <a data-scroll-card data-hover-lift href="/upcoming"
                    class="glass rounded-2xl p-6 flex flex-col items-center gap-4 hover:bg-white/10 transition text-center">
                <div class="w-14 h-14 rounded-2xl bg-violet-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="font-black">Upcoming</p>
            </a>

                <a data-scroll-card data-hover-lift href="/my-tickets"
                    class="glass rounded-2xl p-6 flex flex-col items-center gap-4 hover:bg-white/10 transition text-center">
                <div class="w-14 h-14 rounded-2xl bg-cyan-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <p class="font-black">My Tickets</p>
            </a>

                <a data-scroll-card data-hover-lift href="/transactions"
                    class="glass rounded-2xl p-6 flex flex-col items-center gap-4 hover:bg-white/10 transition text-center">
                <div class="w-14 h-14 rounded-2xl bg-fuchsia-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-fuchsia-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="font-black">Transaksi</p>
            </a>

                <a data-scroll-card data-hover-lift href="/qr-ticket"
                    class="glass rounded-2xl p-6 flex flex-col items-center gap-4 hover:bg-white/10 transition text-center">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <p class="font-black">QR Ticket</p>
            </a>

        </div>
    </div>

    {{-- EXPLORE EVENTS --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-3xl font-black">Event Terbaru</h2>
                <p class="text-slate-400 mt-1">Event yang mungkin kamu suka.</p>
            </div>
            <a href="/events" class="text-violet-400 font-bold hover:text-violet-300 transition">
                Lihat semua →
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($latestEvents as $event)
            <a data-scroll-card data-hover-lift href="{{ route('events.show', $event->slug) }}"
               class="glass rounded-3xl overflow-hidden hover:bg-white/[0.08] transition group">
                <div class="h-44 gradient-card flex items-end p-5">
                    <span class="text-xs font-bold bg-black/30 px-3 py-1 rounded-full backdrop-blur">
                        {{ $event->category->name ?? 'Event' }}
                    </span>
                </div>
                <div class="p-6">
                    <p class="text-slate-400 text-sm">{{ $event->city }} · {{ $event->start_at->format('d M Y') }}</p>
                    <h3 class="text-xl font-black mt-2 group-hover:text-violet-300 transition">{{ $event->title }}</h3>
                    <p class="text-slate-400 text-sm mt-2 line-clamp-2">{{ $event->description }}</p>
                </div>
            </a>
            @empty
            <div class="md:col-span-3 text-center text-slate-400 py-8">Belum ada event tersedia.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
