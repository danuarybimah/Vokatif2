<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - Vokatif</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.16), transparent 18%),
                        radial-gradient(circle at top right, rgba(168, 85, 247, 0.16), transparent 18%),
                        linear-gradient(180deg, #030615 0%, #090e1f 100%);
            color: white;
            min-height: 100vh;
            background-attachment: fixed;
        }

        .glass {
            background: rgba(15, 23, 42, 0.80);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.20);
        }

        .gradient-card {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 50%, #06b6d4 100%);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            padding: 1rem 1.5rem;
            font-weight: 800;
            transition: background 0.2s ease, transform 0.2s ease;
            background: rgba(56, 189, 248, 0.15);
            color: #7dd3fc;
            border: 1px solid rgba(56, 189, 248, 0.28);
        }

        .btn-primary:hover {
            background: rgba(56, 189, 248, 0.24);
            transform: translateY(-1px);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            padding: 1rem 1.5rem;
            font-weight: 800;
            transition: background 0.2s ease, transform 0.2s ease;
            background: rgba(168, 85, 247, 0.16);
            color: #f9a8d4;
            border: 1px solid rgba(168, 85, 247, 0.28);
        }

        .btn-secondary:hover {
            background: rgba(168, 85, 247, 0.24);
            transform: translateY(-1px);
        }

        .input-field,
        .textarea-field,
        .select-field {
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .input-field:focus,
        .textarea-field:focus,
        .select-field:focus {
            outline: none;
            border-color: rgba(56, 189, 248, 0.60);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.10);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .section-title {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title h1 {
            margin: 0;
        }
    </style>
    @stack('head')
</head>
<body class="min-h-screen">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-72 min-h-screen glass p-6 flex flex-col">

        <h1 class="text-3xl font-black mb-10">Vokatif</h1>

        <nav class="space-y-3">

            @php $role = auth()->user()?->role?->slug; @endphp

            @if($role === 'admin')

                <a href="/admin/dashboard"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl glass hover:bg-white/10 transition
                   {{ request()->is('admin/dashboard') ? 'bg-white/10 text-cyan-400' : '' }}">
                    Dashboard
                </a>

                <a href="/events"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl glass hover:bg-white/10 transition
                   {{ request()->is('events*') ? 'bg-white/10 text-cyan-400' : '' }}">
                    Events
                </a>

                <a href="/admin/analytics"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl glass hover:bg-white/10 transition
                   {{ request()->is('admin/analytics') ? 'bg-white/10 text-cyan-400' : '' }}">
                    Analytics
                </a>

            @elseif($role === 'organizer')

                <a href="/organizer/dashboard"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl glass hover:bg-white/10 transition
                   {{ request()->is('organizer/dashboard') ? 'bg-white/10 text-fuchsia-400' : '' }}">
                    Dashboard
                </a>

                <a href="/organizer/events"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl glass hover:bg-white/10 transition
                   {{ request()->is('organizer/events*') ? 'bg-white/10 text-fuchsia-400' : '' }}">
                    Events
                </a>

                <a href="/organizer/analytics"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl glass hover:bg-white/10 transition
                   {{ request()->is('organizer/analytics') ? 'bg-white/10 text-fuchsia-400' : '' }}">
                    Analytics
                </a>

                <a href="/organizer/checkin-scanner"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl glass hover:bg-white/10 transition
                   {{ request()->is('organizer/checkin-scanner') ? 'bg-white/10 text-fuchsia-400' : '' }}">
                    QR Scanner
                </a>

            @else

                <a href="/events"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl glass hover:bg-white/10 transition
                   {{ request()->is('events*') ? 'bg-white/10 text-emerald-400' : '' }}">
                    Events
                </a>

            @endif

        </nav>

    </aside>

    <main class="flex-1 min-w-0">

        <!-- TOPBAR -->
        <div class="px-10 py-6 border-b border-white/5 flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-black">
                    Welcome back, {{ auth()->user()->name ?? 'Guest' }}
                </h2>
                <p class="text-slate-400 mt-1">
                    {{ ucfirst(auth()->user()?->role?->slug ?? '-') }} Account
                </p>
            </div>

            <div class="flex items-center gap-4">

                {{-- MY TICKETS — hanya untuk user --}}
                @if(auth()->user()?->role?->slug === 'user' || !auth()->user()?->role)
                    <a href="/my-tickets"
                       class="px-5 py-3 rounded-2xl
                       {{ request()->is('my-tickets*') ? 'bg-emerald-500/30 text-emerald-300' : 'bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30' }}
                       font-bold transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        My Tickets
                    </a>
                @endif

                {{-- PROFILE DROPDOWN --}}
                <div class="relative" x-data="{ open: false }">

                    <button @click="open = !open"
                            class="glass px-5 py-3 rounded-2xl flex items-center gap-3 hover:bg-white/10 transition">

                        {{-- AVATAR --}}
                        <div class="w-9 h-9 rounded-full gradient-card flex items-center justify-center font-black text-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>

                        <div class="text-left">
                            <p class="text-slate-400 text-xs">Logged in as</p>
                            <p class="font-bold text-sm">{{ auth()->user()->email ?? '-' }}</p>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 transition" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>

                    </button>

                    {{-- DROPDOWN MENU --}}
                    <div x-show="open"
                         @click.outside="open = false"
                         x-transition
                         class="absolute right-0 mt-3 w-56 glass rounded-2xl p-2 z-50 shadow-2xl">

                        <a href="/profile"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-bold">Profil Saya</span>
                        </a>

                        <div class="border-t border-white/10 my-2"></div>

                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="font-bold">Logout</span>
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="p-10">
            @yield('content')
        </div>

        <!-- FOOTER -->
        @include('partials.footer')
    </main>

</div>

{{-- Alpine.js untuk dropdown --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@stack('scripts')
</body>
</html>
