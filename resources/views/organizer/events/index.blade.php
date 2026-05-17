@extends('layouts.dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">

        <div class="section-header mb-10">

            <div>

                <h1 class="text-5xl font-black">
                    Manage Events
                </h1>

                <p class="text-slate-400 mt-3 max-w-2xl leading-7">
                    Tambahkan jadwal terbaru dan atur semua event secara profesional dengan tampilan event yang clean dan modern.
                </p>

            </div>

            <a href="/organizer/events/create"
                class="btn-primary">
                + Tambah Event
            </a>

        </div>

        @if (session('success'))
            <div id="flash-success"
                class="bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 px-6 py-4 rounded-2xl mb-6 flex items-center justify-between"
                style="transition: opacity 0.5s ease;">
                <span>✓ {{ session('success') }}</span>
                <button onclick="document.getElementById('flash-success').style.opacity='0'"
                    class="text-emerald-400 font-bold ml-4 text-lg leading-none">✕</button>
            </div>

            @push('scripts')
                <script>
                    setTimeout(() => {
                        const el = document.getElementById('flash-success');
                        if (el) {
                            el.style.opacity = '0';
                            setTimeout(() => el.remove(), 500); // hapus setelah animasi selesai
                        }
                    }, 3000);
                </script>
            @endpush
        @endif

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse ($events as $event)
                <div class="glass rounded-[32px] overflow-hidden border border-white/10">

                    <div class="relative h-56 overflow-hidden">
                        @if ($event->cover_image)
                            <img src="{{ asset('storage/' . $event->cover_image) }}"
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover transition duration-500 hover:scale-105">
                        @else
                            <div class="h-full gradient-card"></div>
                        @endif
                    </div>

                    <div class="p-6 space-y-5">

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <span class="text-xs px-3 py-1 rounded-full bg-violet-500/20 text-violet-300 font-semibold">
                                {{ $event->category->name ?? 'Event' }}
                            </span>

                            <span class="text-xs uppercase tracking-[0.2em] font-semibold text-slate-400">
                                {{ $event->status === 'published' ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        <div>
                            <h2 class="text-2xl font-black leading-tight">
                                {{ $event->title }}
                            </h2>
                            <p class="text-slate-400 mt-3 line-clamp-3 leading-7">
                                {{ $event->description }}
                            </p>
                        </div>

                        <div class="grid gap-3 text-sm text-slate-400">
                            <div class="flex items-center justify-between border-t border-white/10 pt-3">
                                <span>Location</span>
                                <span>{{ $event->city }}, {{ $event->location }}</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-white/10 pt-3">
                                <span>Schedule</span>
                                <span>{{ optional($event->start_at)->format('d M Y H:i') ?? 'TBA' }}</span>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between gap-3">
                            <a href="/organizer/events/{{ $event->id }}/edit"
                                class="btn-secondary w-full text-center">
                                Edit Event
                            </a>
                        </div>

                    </div>

                </div>
            @empty
                <div class="glass rounded-3xl p-10 col-span-full text-center border border-white/10">
                    <h3 class="text-3xl font-black mb-4">Belum ada event</h3>
                    <p class="text-slate-400 mb-6">Silakan tambah event baru untuk mulai menjadwalkan dan mempromosikannya.</p>
                    <a href="/organizer/events/create" class="btn-primary">Tambah Event Sekarang</a>
                </div>
            @endforelse

        </div>

    </div>
@endsection
