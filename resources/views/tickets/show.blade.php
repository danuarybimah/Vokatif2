@extends('layouts.user')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-10">

        <h1 class="text-5xl font-black">
            Digital Ticket
        </h1>

        <p class="text-slate-400 mt-3">
            Tunjukkan QR ini kepada panitia saat check-in.
        </p>

    </div>

    <div class="grid lg:grid-cols-2 gap-8">

        <!-- LEFT -->
        <div class="glass rounded-[40px] p-10">

            <!-- HEADER -->
            <div class="gradient-card rounded-[32px] p-8 mb-8">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-white/70">
                            EVENT
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            {{ $ticket->event->title }}
                        </h2>

                    </div>

                    <div class="text-right">

                        <p class="text-sm text-white/70">
                            STATUS
                        </p>

                        <h3 class="text-xl font-black mt-2">

                            @if($ticket->status == 'active')

                                <span class="text-emerald-200">
                                    ACTIVE
                                </span>

                            @elseif($ticket->status == 'used')

                                <span class="text-red-200">
                                    USED
                                </span>

                            @else

                                <span class="text-yellow-200">
                                    INVALID
                                </span>

                            @endif

                        </h3>

                    </div>

                </div>

            </div>

            <!-- DETAILS -->
            <div class="space-y-6">

                <div>

                    <p class="text-sm text-slate-500">
                        Attendee
                    </p>

                    <h2 class="text-3xl font-black">
                        {{ $ticket->user->name }}
                    </h2>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Ticket Type
                    </p>

                    <h2 class="text-2xl font-black text-cyan-300">
                        {{ $ticket->ticketType->name }}
                    </h2>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Ticket Code
                    </p>

                    <h2 class="text-xl font-black break-all text-violet-300">
                        {{ $ticket->ticket_code }}
                    </h2>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Event Location
                    </p>

                    <h2 class="text-xl font-bold">
                        {{ $ticket->event->location }}
                    </h2>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Event Date
                    </p>

                    <h2 class="text-xl font-bold">
                        {{ $ticket->event->start_at->format('d M Y H:i') }}
                    </h2>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="glass rounded-[40px] p-10 flex flex-col justify-center items-center">

            <!-- QR -->
            <div class="bg-white rounded-[32px] p-8 shadow-2xl">

                {!!
                    QrCode::format('svg')
                        ->size(320)
                        ->margin(2)
                        ->generate($ticket->ticket_code)
                !!}

            </div>

            <!-- CODE -->
            <div class="mt-8 text-center">

                <h2 class="text-2xl font-black">
                    Scan QR Ticket
                </h2>

                <p class="text-slate-400 mt-3">
                    QR digunakan untuk validasi check-in event.
                </p>

                <div class="mt-6 px-6 py-4 rounded-2xl bg-violet-500/10 border border-violet-500/20">

                    <p class="text-sm text-slate-400">
                        QR Payload
                    </p>

                    <h2 class="text-lg font-black text-violet-300 mt-2 break-all">
                        {{ $ticket->ticket_code }}
                    </h2>

                </div>

            </div>

            <!-- BUTTON -->
            <button onclick="window.print()"
                    class="mt-8 px-8 py-4 rounded-2xl bg-violet-600 hover:bg-violet-500 font-black transition">

                Download / Print Ticket

            </button>

        </div>

    </div>

</div>

@endsection
