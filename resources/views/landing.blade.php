<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokatif - Event & Ticketing Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-white">
    <!-- HEADER -->
    @include('partials.header')

    <!-- MAIN CONTENT -->
    <main class="min-h-screen">
        <!-- HERO SECTION -->
        <section class="px-6 py-20 lg:py-32">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- HERO TEXT -->
                    <div class="order-2 lg:order-1">
                        <div class="space-y-6">
                            <div class="inline-flex rounded-full border border-violet-400/30 bg-violet-500/10 px-4 py-2 text-sm text-violet-200 backdrop-blur-sm">
                                <span class="font-semibold"> Event Management Platform</span>
                            </div>

                            <div class="space-y-4">
                                <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-violet-200 to-fuchsia-200">
                                    Temukan Event, Beli Tiket, Check-in QR
                                </h1>
                                <p class="text-lg text-slate-400 max-w-xl leading-relaxed">
                                    Vokatif adalah platform manajemen event dan ticketing modern berbasis Laravel API dengan sistem QR Code, JWT Authentication, dan transaksi tiket yang aman.
                                </p>
                            </div>

                            <!-- CTA BUTTONS -->
                            <div class="flex flex-wrap gap-4 pt-4">
                                <a href="{{ route('events.index') }}"
                                   class="group relative inline-flex items-center gap-2 px-6 py-3 font-bold text-white rounded-lg bg-gradient-to-r from-violet-600 to-fuchsia-600 hover:shadow-lg hover:shadow-violet-500/50 transition-all duration-300 transform hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Explore Events
                                </a>

                                <a href="/api/v1/health"
                                   class="group inline-flex items-center gap-2 px-6 py-3 font-bold text-white rounded-lg border-2 border-violet-500/50 bg-violet-500/10 hover:bg-violet-500/20 hover:border-violet-400 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.251a.75.75 0 0 0 0 1.06l5.379 5.379M21 10.75A3.75 3.75 0 0 0 17.25 7H5m0 0A3.75 3.75 0 0 1 8.75 3h8.5A3.75 3.75 0 0 1 21 6.75" />
                                    </svg>
                                    Test API
                                </a>
                            </div>

                            <!-- STATS -->
                            <div class="grid grid-cols-3 gap-4 pt-8 border-t border-white/10">
                                <div class="space-y-1">
                                    <p class="text-2xl font-black text-violet-400">100+</p>
                                    <p class="text-sm text-slate-400">Events Active</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-2xl font-black text-violet-400">10K+</p>
                                    <p class="text-sm text-slate-400">Tickets Sold</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-2xl font-black text-violet-400">99.9%</p>
                                    <p class="text-sm text-slate-400">Uptime SLA</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HERO VISUAL -->
                    <div class="order-1 lg:order-2">
                        <div class="relative">
                            <!-- Animated background -->
                            <div class="absolute inset-0 bg-gradient-to-br from-violet-600/20 via-fuchsia-600/20 to-cyan-600/20 rounded-3xl blur-3xl"></div>
                            
                            <div class="relative rounded-3xl border border-white/10 bg-gradient-to-br from-white/[0.08] to-white/[0.02] p-8 backdrop-blur-xl shadow-2xl">
                                <div class="space-y-4">
                                    <!-- Header Preview -->
                                    <div class="rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 p-6 space-y-3">
                                        <div class="h-4 bg-white/20 rounded w-3/4"></div>
                                        <div class="h-3 bg-white/20 rounded w-1/2"></div>
                                        <div class="space-y-2 pt-2">
                                            <div class="h-3 bg-white/10 rounded"></div>
                                            <div class="h-3 bg-white/10 rounded"></div>
                                        </div>
                                    </div>

                                    <!-- Content Cards -->
                                    <div class="space-y-3">
                                        <div class="rounded-xl bg-white/5 border border-white/10 p-4 flex gap-3">
                                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-violet-500 to-fuchsia-500 flex-shrink-0"></div>
                                            <div class="flex-1 space-y-2">
                                                <div class="h-3 bg-white/20 rounded w-2/3"></div>
                                                <div class="h-2 bg-white/10 rounded w-1/2"></div>
                                            </div>
                                        </div>
                                        <div class="rounded-xl bg-white/5 border border-white/10 p-4 flex gap-3">
                                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-cyan-500 to-violet-500 flex-shrink-0"></div>
                                            <div class="flex-1 space-y-2">
                                                <div class="h-3 bg-white/20 rounded w-2/3"></div>
                                                <div class="h-2 bg-white/10 rounded w-1/2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURED EVENTS SECTION -->
        <section class="px-6 py-20 border-t border-white/5">
            <div class="max-w-7xl mx-auto">
                <div class="space-y-12">
                    <!-- Section Header -->
                    <div class="space-y-4">
                        <h2 class="text-4xl lg:text-5xl font-black">Featured Events</h2>
                        <p class="text-slate-400 text-lg max-w-2xl">Jelajahi event-event terbaik dan terbaru yang tersedia di platform Vokatif.</p>
                    </div>

                    <!-- Events Grid -->
                    <div class="grid md:grid-cols-3 gap-6">
                        @forelse ($featuredEvents as $event)
                            <a href="{{ route('events.show', $event->slug) }}"
                               class="group rounded-2xl border border-white/10 bg-white/[0.03] hover:bg-white/[0.08] backdrop-blur-sm p-6 transition-all duration-300 hover:border-violet-400/50 hover:shadow-xl hover:shadow-violet-500/10">
                                <!-- Event Image Placeholder -->
                                <div class="relative h-48 rounded-xl bg-gradient-to-br from-violet-600 to-cyan-400 mb-6 overflow-hidden group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                                </div>

                                <!-- Event Info -->
                                <div class="space-y-3">
                                    <p class="text-sm text-violet-400 font-semibold">
                                        {{ $event->city }} • {{ $event->start_at->format('d M Y') }}
                                    </p>

                                    <h3 class="text-lg lg:text-xl font-black line-clamp-2 group-hover:text-violet-400 transition-colors">
                                        {{ $event->title }}
                                    </h3>

                                    <p class="text-sm text-slate-400 line-clamp-2">
                                        {{ $event->description }}
                                    </p>

                                    <!-- CTA -->
                                    <div class="pt-3 flex items-center gap-2 text-violet-400 font-semibold text-sm group-hover:gap-3 transition-all">
                                        View Details
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="md:col-span-3 rounded-2xl border-2 border-dashed border-white/10 bg-white/[0.03] backdrop-blur-sm p-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12a5 5 0 1010 0A5 5 0 017 12z" />
                                </svg>
                                <h3 class="text-lg font-bold text-slate-400">Belum ada event featured.</h3>
                                <p class="mt-2 text-slate-500 text-sm">Pastikan seeder event sudah dijalankan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- CATEGORIES SECTION -->
        <section class="px-6 py-20 border-t border-white/5">
            <div class="max-w-7xl mx-auto">
                <div class="space-y-12">
                    <!-- Section Header -->
                    <div class="space-y-4">
                        <h2 class="text-4xl lg:text-5xl font-black">Kategori Event</h2>
                        <p class="text-slate-400 text-lg max-w-2xl">Temukan event berdasarkan kategori yang Anda minati.</p>
                    </div>

                    <!-- Categories Grid -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($categories as $category)
                            <a href="{{ route('events.index', ['category' => $category->slug]) }}"
                               class="group relative rounded-lg border border-white/10 bg-white/[0.05] hover:bg-white/[0.10] backdrop-blur-sm px-6 py-4 transition-all duration-300 hover:border-violet-400/50 overflow-hidden">
                                <!-- Background gradient on hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-violet-500/10 to-fuchsia-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                
                                <div class="relative flex items-center justify-between">
                                    <div>
                                        <h3 class="font-bold text-white group-hover:text-violet-400 transition-colors">{{ $category->name }}</h3>
                                        <p class="text-xs text-slate-400 mt-1">{{ $category->events_count }} events</p>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500 group-hover:text-violet-400 transition-colors group-hover:translate-x-1 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    @include('partials.footer')
</body>
</html>