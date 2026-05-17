<!-- PROFESSIONAL HEADER -->
<nav class="sticky top-0 z-50 backdrop-blur-md border-b border-white/5 bg-slate-950/80">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- LOGO & BRAND -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center font-black text-sm text-white">
                    V
                </div>
                <div>
                    <h1 class="text-lg font-black tracking-tight">Vokatif</h1>
                    <p class="text-xs text-slate-400">Event Platform</p>
                </div>
            </div>

            <!-- NAV MENU -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="/" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors duration-200">
                    Home
                </a>
                <a href="/events" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors duration-200">
                    Events
                </a>
                <a href="#" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors duration-200">
                    About
                </a>
                <a href="#" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors duration-200">
                    Contact
                </a>
            </div>

            <!-- RIGHT SECTION -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- PROFILE DROPDOWN -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors duration-200">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center font-bold text-sm text-white">
                                {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="font-semibold text-sm">{{ auth()->user()?->name ?? '-' }}</p>
                                <p class="text-slate-400 text-xs">{{ auth()->user()?->role?->name ?? 'User' }}</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- DROPDOWN MENU -->
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-3 w-56 rounded-xl bg-slate-900/95 backdrop-blur-md border border-white/10 shadow-2xl overflow-hidden">
                            
                            <div class="px-4 py-4 border-b border-white/10 bg-gradient-to-r from-violet-500/10 to-fuchsia-500/10">
                                <p class="font-bold text-white">{{ auth()->user()?->name }}</p>
                                <p class="text-slate-400 text-sm mt-1">{{ auth()->user()?->email }}</p>
                            </div>

                            <div class="p-2">
                                <a href="/home" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-colors text-sm font-semibold text-slate-300 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </a>
                                <a href="/profile" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-colors text-sm font-semibold text-slate-300 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    My Profile
                                </a>
                                <a href="/my-tickets" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-colors text-sm font-semibold text-slate-300 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    My Tickets
                                </a>
                                <a href="/transactions" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-colors text-sm font-semibold text-slate-300 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    History
                                </a>
                                <div class="border-t border-white/10 my-2"></div>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500/20 transition-colors text-sm font-semibold text-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="/login" class="px-4 py-2 text-sm font-semibold text-slate-300 hover:text-white transition-colors duration-200">
                        Sign In
                    </a>
                    <a href="/register" class="px-4 py-2 rounded-lg bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white text-sm font-bold hover:shadow-lg hover:shadow-violet-500/50 transition-all duration-200">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
