@extends('layouts.user')

@section('content')
<div class="space-y-8">

    <div>
        <h1 class="text-5xl font-black">QR Tickets</h1>
        <p class="text-slate-400 mt-3">Semua QR tiket aktif kamu.</p>
    </div>

    <!-- BACK BUTTON -->
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
        <div class="glass rounded-[32px] p-8 flex flex-col md:flex-row gap-8 items-center">

            <!-- QR CODE -->
            <div class="flex-shrink-0 glass rounded-2xl p-6 flex flex-col items-center gap-4">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ $ticket->ticket_code }}"
                     alt="QR {{ $ticket->ticket_code }}"
                     class="rounded-xl">
                <p class="font-mono text-sm text-slate-300">{{ $ticket->ticket_code }}</p>
            </div>

            <!-- INFO -->
            <div class="flex-1 space-y-4">

                <div>
                    <h2 class="text-3xl font-black">{{ $ticket->event->title }}</h2>
                    <p class="text-slate-400 mt-1">{{ $ticket->event->city }} · {{ $ticket->event->start_at->format('d M Y H:i') }} WIB</p>
                </div>

                <div class="grid sm:grid-cols-3 gap-3">
                    <div class="glass rounded-xl p-4">
                        <p class="text-xs text-slate-400">Tipe Tiket</p>
                        <p class="font-bold mt-1 text-cyan-400">{{ $ticket->ticketType->name }}</p>
                    </div>
                    <div class="glass rounded-xl p-4">
                        <p class="text-xs text-slate-400">Status</p>
                        @if($ticket->status === 'active')
                            <p class="font-bold mt-1 text-emerald-400">ACTIVE</p>
                        @elseif($ticket->status === 'used')
                            <p class="font-bold mt-1 text-red-400">USED</p>
                        @else
                            <p class="font-bold mt-1 text-slate-400">INVALID</p>
                        @endif
                    </div>
                    <div class="glass rounded-xl p-4">
                        <p class="text-xs text-slate-400">Dibeli</p>
                        <p class="font-bold mt-1">{{ $ticket->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <a href="{{ route('tickets.show', $ticket->ticket_code) }}"
                   class="inline-block px-6 py-3 rounded-2xl bg-violet-600 hover:bg-violet-500 font-bold transition">
                    Lihat Detail Tiket
                </a>

            </div>

        </div>
    @empty
        <div class="glass rounded-[32px] p-16 text-center">
            <h2 class="text-3xl font-black">Belum ada tiket aktif</h2>
            <p class="text-slate-400 mt-3">Beli tiket untuk mendapatkan QR Code.</p>
            <a href="/events" class="inline-block mt-6 px-8 py-4 rounded-2xl bg-violet-600 hover:bg-violet-500 font-bold transition">
                Explore Events
            </a>
        </div>
    @endforelse

</div>
@endsection
