@php
    $role = auth()->user()?->role?->slug;
    $layout = ($role === 'admin' || $role === 'organizer') ? 'layouts.dashboard' : 'layouts.user';
@endphp

@extends($layout)

@section('content')

    <div class="max-w-7xl mx-auto">

        <!-- HERO -->
        <section class="relative overflow-hidden">

            <div class="absolute inset-0 gradient-card opacity-20 rounded-[40px]"></div>

            <div class="relative grid lg:grid-cols-2 gap-10 items-center glass rounded-[40px] p-10">

                <div>

                    <a href="{{ route('events.index') }}" class="text-sm text-violet-300 hover:text-violet-200">

                        ← Kembali ke daftar event

                    </a>

                    <div class="mt-6">

                        <span
                            class="rounded-full bg-violet-600/30 border border-violet-400/30 px-4 py-2 text-sm font-bold text-violet-200">

                            {{ $event->category->name ?? 'Event' }}

                        </span>

                    </div>

                    <h1 class="mt-6 text-5xl md:text-7xl font-black leading-tight">

                        {{ $event->title }}

                    </h1>

                    <p class="mt-6 text-slate-300 text-lg leading-relaxed">

                        {{ $event->description }}

                    </p>

                    <div class="mt-8 grid sm:grid-cols-3 gap-4">

                        <div class="glass rounded-2xl p-4">

                            <p class="text-xs text-slate-400">
                                Tanggal
                            </p>

                            <p class="mt-1 font-bold">
                                {{ $event->start_at->format('d M Y') }}
                            </p>

                        </div>

                        <div class="glass rounded-2xl p-4">

                            <p class="text-xs text-slate-400">
                                Waktu
                            </p>

                            <p class="mt-1 font-bold">
                                {{ $event->start_at->format('H:i') }} WIB
                            </p>

                        </div>

                        <div class="glass rounded-2xl p-4">

                            <p class="text-xs text-slate-400">
                                Kota
                            </p>

                            <p class="mt-1 font-bold">
                                {{ $event->city }}
                            </p>

                        </div>

                    </div>

                </div>

                <!-- IMAGE -->
                <div class="relative rounded-[32px] overflow-hidden h-[500px]">
                    @if($event->cover_image)
                        <img src="{{ asset('storage/' . $event->cover_image) }}"
                             alt="{{ $event->title }}"
                             class="object-cover w-full h-full">
                    @else
                        <div class="gradient-card h-full"></div>
                    @endif

                    <div class="absolute inset-0 bg-black/30"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <p class="text-white/70 text-sm font-bold">
                            Presented by
                        </p>

                        <h2 class="text-4xl font-black mt-2">
                            {{ $event->organizer->organizerProfile->organization_name ?? $event->organizer->name }}
                        </h2>
                    </div>
                </div>

            </div>

        </section>

        <!-- CONTENT -->
        <section class="grid lg:grid-cols-3 gap-8 mt-12">

            <!-- LEFT -->
            <div class="lg:col-span-2">

                <div class="glass rounded-[32px] p-8">

                    <h2 class="text-4xl font-black mb-6">
                        Detail Event
                    </h2>

                    <p class="text-slate-300 leading-relaxed text-lg">

                        {{ $event->description }}

                    </p>

                    <div class="mt-10 glass rounded-3xl p-6">

                        <p class="text-sm text-slate-400">
                            Lokasi Event
                        </p>

                        <h3 class="mt-2 text-3xl font-black">

                            {{ $event->location }}

                        </h3>

                        <p class="mt-2 text-slate-400">

                            {{ $event->city }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <aside>

                <div class="sticky top-6 glass rounded-[32px] p-8">

                    <h2 class="text-3xl font-black">
                        Pilih Tiket
                    </h2>

                    <p class="mt-3 text-slate-400">
                        Pembelian tiket dilakukan melalui API order Vokatif.
                    </p>

                    <div class="mt-8 space-y-4">

                        @foreach ($event->ticketTypes as $ticketType)
                            <form action="{{ route('buy.ticket') }}" method="POST" class="glass rounded-3xl p-6 mb-5">

                                @csrf

                                <input type="hidden" name="event_id" value="{{ $event->id }}">

                                <input type="hidden" name="ticket_type_id" value="{{ $ticketType->id }}">

                                <div class="flex items-center justify-between">

                                    <div>

                                        <h2 class="text-2xl font-black">
                                            {{ $ticketType->name }}
                                        </h2>

                                        <p class="text-slate-400 mt-2">
                                            Sisa {{ $ticketType->quota }} tiket
                                        </p>

                                    </div>

                                    <div class="text-right">

                                        <h2 class="text-4xl font-black text-cyan-300">
                                            Rp{{ number_format($ticketType->price, 0, ',', '.') }}
                                        </h2>

                                        <button type="submit"
                                            class="mt-4 px-6 py-3 rounded-2xl bg-violet-600 hover:bg-violet-500 transition font-bold">

                                            Buy Ticket

                                        </button>

                                    </div>

                                </div>

                            </form>
                        @endforeach

                    </div>

                    <div class="mt-8 rounded-3xl bg-violet-600/20 border border-violet-400/30 p-5">

                        <p class="text-sm text-violet-100">
                            Untuk demo UAS, beli tiket lewat Postman:
                        </p>

                        <code class="mt-3 block text-sm text-violet-200">
                            POST /api/v1/orders
                        </code>

                        <p class="mt-3 text-xs text-slate-400">
                            event_id: {{ $event->id }}
                        </p>

                    </div>

                </div>

            </aside>

        </section>

    </div>

@endsection
