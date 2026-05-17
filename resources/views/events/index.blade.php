@php
    $role = auth()->user()?->role?->slug;
    $layout = ($role === 'admin' || $role === 'organizer') ? 'layouts.dashboard' : 'layouts.user';
@endphp

@extends($layout)

@section('content')

<div>

    <!-- HERO -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">

        <div>
            <a href="{{ route('home') }}"
               class="text-sm text-violet-300 hover:text-violet-200">
                ← Kembali ke beranda
            </a>
            <h1 class="mt-4 text-4xl md:text-6xl font-black tracking-tight">
                Jelajahi Event
            </h1>
            <p class="mt-4 text-slate-400 max-w-2xl">
                Temukan event teknologi, musik, bisnis, edukasi,
                dan lifestyle terbaik di Vokatif.
            </p>
        </div>

        <!-- SEARCH -->
        <form method="GET" action="{{ route('events.index') }}" class="flex gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari event atau kota..."
                class="w-64 rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm outline-none focus:border-violet-400"
            >
            <button class="rounded-2xl bg-violet-600 px-5 py-3 text-sm font-bold hover:bg-violet-500 transition">
                Cari
            </button>
        </form>

    </div>

    <!-- CATEGORY -->
    <div class="flex flex-wrap gap-3 mb-10">

        <a href="{{ route('events.index') }}"
           class="rounded-full px-4 py-2 text-sm transition
           {{ request('category') ? 'bg-white/10 text-slate-300' : 'bg-violet-600 text-white' }}">
            Semua
        </a>

        @foreach ($categories as $category)
            <a href="{{ route('events.index', ['category' => $category->slug]) }}"
               class="rounded-full px-4 py-2 text-sm transition
               {{ request('category') === $category->slug ? 'bg-violet-600 text-white' : 'bg-white/10 text-slate-300 hover:bg-white/15' }}">
                {{ $category->name }}
            </a>
        @endforeach

    </div>

    <!-- EVENT GRID -->
    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse ($events as $event)

            <a href="{{ route('events.show', $event->slug) }}"
               class="group glass rounded-3xl p-5 hover:bg-white/[0.08] transition duration-300">

                <div class="h-56 rounded-3xl overflow-hidden relative mb-5">
                @if($event->cover_image)
                    <img src="{{ asset('storage/' . $event->cover_image) }}"
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="gradient-card h-full"></div>
                @endif
                <div class="absolute inset-x-0 bottom-0 p-5 bg-gradient-to-t from-black/60 via-black/10 to-transparent">
                    <span class="rounded-full bg-black/60 px-3 py-1 text-xs font-bold backdrop-blur">
                        {{ $event->category->name ?? 'Event' }}
                    </span>
                </div>
            </div>

                <div class="flex items-center gap-3 text-sm text-slate-400 mb-4">
                    <span>{{ $event->city }}</span>
                    <span>•</span>
                    <span>{{ $event->start_at->format('d M Y') }}</span>
                </div>

                <h2 class="text-2xl font-black group-hover:text-violet-300 transition">
                    {{ $event->title }}
                </h2>

                <p class="mt-4 text-slate-400 line-clamp-2 leading-relaxed">
                    {{ $event->description }}
                </p>

                <div class="mt-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Mulai dari</p>
                        <h3 class="text-3xl font-black text-cyan-300">
                            Rp{{ number_format($event->ticketTypes->min('price') ?? 0, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="px-4 py-3 rounded-2xl bg-white/10 text-sm font-bold">
                        Detail
                    </div>
                </div>

            </a>

        @empty

            <div class="md:col-span-3 glass rounded-3xl p-10 text-center">
                <h2 class="text-3xl font-black">Event belum ditemukan</h2>
                <p class="mt-4 text-slate-400">Coba kata kunci atau kategori lain.</p>
            </div>

        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-10">
        {{ $events->links() }}
    </div>

</div>

@endsection
