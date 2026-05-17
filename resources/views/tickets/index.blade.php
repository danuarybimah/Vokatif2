@extends('layouts.user')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-10">

        <div>

            <h1 class="text-5xl font-black">
                My Tickets
            </h1>

            <p class="text-slate-400 mt-3">
                Semua ticket event milik kamu.
            </p>

        </div>

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
        
    <!-- TABLE -->
    <div class="glass rounded-[32px] overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b border-white/10 bg-white/5">

                    <tr>

                        <th class="text-left px-8 py-6 text-slate-400">
                            Event
                        </th>

                        <th class="text-left px-8 py-6 text-slate-400">
                            Ticket Type
                        </th>

                        <th class="text-left px-8 py-6 text-slate-400">
                            Ticket Code
                        </th>

                        <th class="text-left px-8 py-6 text-slate-400">
                            Status
                        </th>

                        <th class="text-left px-8 py-6 text-slate-400">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($tickets as $ticket)

                        <tr class="border-b border-white/5 hover:bg-white/5 transition">

                            <!-- EVENT -->
                            <td class="px-8 py-6">

                                <div>

                                    <h2 class="font-black text-xl">
                                        {{ $ticket->event->title }}
                                    </h2>

                                    <p class="text-slate-400 text-sm mt-1">
                                        {{ $ticket->event->city }}
                                    </p>

                                </div>

                            </td>

                            <!-- TYPE -->
                            <td class="px-8 py-6">

                                <span class="text-cyan-400 font-bold">
                                    {{ $ticket->ticketType->name }}
                                </span>

                            </td>

                            <!-- CODE -->
                            <td class="px-8 py-6">

                                <div class="space-y-2">

                                    <span class="font-mono text-sm block">
                                        {{ $ticket->ticket_code }}
                                    </span>

                                    <span class="text-xs text-slate-500">
                                        {{ $ticket->created_at->format('d M Y H:i') }}
                                    </span>

                                </div>

                            </td>

                            <!-- STATUS -->
                            <td class="px-8 py-6">

                                @if($ticket->status === 'active')

                                    <span class="px-4 py-2 rounded-full bg-emerald-500/20 text-emerald-400 text-sm font-bold">
                                        ACTIVE
                                    </span>

                                @elseif($ticket->status === 'used')

                                    <span class="px-4 py-2 rounded-full bg-red-500/20 text-red-400 text-sm font-bold">
                                        USED
                                    </span>

                                @else

                                    <span class="px-4 py-2 rounded-full bg-slate-500/20 text-slate-300 text-sm font-bold">
                                        INVALID
                                    </span>

                                @endif

                            </td>

                            <!-- ACTION -->
                            <td class="px-8 py-6">

                                <div class="flex items-center gap-3">

                                    <!-- QR -->
                                    <a href="{{ route('tickets.show', $ticket->ticket_code) }}"
                                       class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-violet-600 hover:bg-violet-500 transition font-bold">

                                        View QR

                                    </a>

                                    <!-- EVENT -->
                                    <a href="{{ route('events.show', $ticket->event->slug) }}"
                                       class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-cyan-500/20 text-cyan-300 hover:bg-cyan-500/30 transition font-bold">

                                        Event

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center py-20">

                                <div class="space-y-4">

                                    <h2 class="text-4xl font-black">
                                        Belum ada ticket
                                    </h2>

                                    <p class="text-slate-400">
                                        Ticket akan muncul setelah membeli event.
                                    </p>

                                    <a href="/events"
                                       class="inline-block mt-4 px-6 py-4 rounded-2xl bg-violet-600 hover:bg-violet-500 font-bold transition">

                                        Explore Events

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
