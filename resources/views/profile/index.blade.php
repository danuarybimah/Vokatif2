@extends($layout)

@section('content')
    <div class="max-w-3xl mx-auto space-y-8">

        <!-- HEADER -->
        <div>
            <h1 class="text-5xl font-black">Profil Saya</h1>
            <p class="text-slate-400 mt-3">Kelola informasi akun kamu.</p>
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

        {{-- FLASH --}}
        @if (session('success'))
            <div id="flash-success"
                class="bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 px-6 py-4 rounded-2xl flex items-center justify-between"
                style="transition: opacity 0.5s ease;">
                <span>✓ {{ session('success') }}</span>
                <button onclick="document.getElementById('flash-success').remove()"
                    class="text-emerald-400 font-bold ml-4">✕</button>
            </div>

            @push('scripts')
                <script>
                    setTimeout(() => {
                        const el = document.getElementById('flash-success');
                        if (el) {
                            el.style.opacity = '0';
                            setTimeout(() => el.remove(), 500);
                        }
                    }, 3000);
                </script>
            @endpush
        @endif

        <!-- AVATAR CARD -->
        <div class="glass rounded-[32px] p-8 flex items-center gap-8">

            <div
                class="w-24 h-24 rounded-full gradient-card flex items-center justify-center font-black text-4xl flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <h2 class="text-3xl font-black">{{ $user->name }}</h2>
                <p class="text-slate-400 mt-1">{{ $user->email }}</p>
                <span
                    class="mt-3 inline-block px-4 py-1 rounded-full text-sm font-bold
                {{ $user->role?->slug === 'admin'
                    ? 'bg-cyan-500/20 text-cyan-400'
                    : ($user->role?->slug === 'organizer'
                        ? 'bg-fuchsia-500/20 text-fuchsia-400'
                        : 'bg-emerald-500/20 text-emerald-400') }}">
                    {{ ucfirst($user->role?->slug ?? 'user') }}
                </span>
            </div>

        </div>

        <!-- EDIT FORM -->
        <div class="glass rounded-[32px] p-8">

            <h2 class="text-2xl font-black mb-8">Edit Informasi</h2>

            <form action="/profile" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-3 text-slate-300 font-bold">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400 transition">
                        @error('name')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-3 text-slate-300 font-bold">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400 transition">
                        @error('email')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="border-t border-white/10 pt-6">
                    <h3 class="text-lg font-black mb-6 text-slate-300">Ganti Password <span
                            class="text-slate-500 font-normal text-sm">(kosongkan jika tidak ingin ganti)</span></h3>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>
                            <label class="block mb-3 text-slate-300 font-bold">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password" id="new_password"
                                    class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400 pr-14 transition"
                                    placeholder="Minimal 8 karakter">
                                <button type="button" onclick="togglePassword('new_password', 'eye1')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition">
                                    <svg id="eye1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-3 text-slate-300 font-bold">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="confirm_password"
                                    class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400 pr-14 transition"
                                    placeholder="Ulangi password baru">
                                <button type="button" onclick="togglePassword('confirm_password', 'eye2')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition">
                                    <svg id="eye2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <button
                    class="w-full bg-gradient-to-r from-violet-600 to-cyan-500 rounded-2xl py-5 font-black text-xl hover:scale-[1.02] transition">
                    Simpan Perubahan
                </button>

            </form>

        </div>

        <!-- INFO CARD -->
        <div class="glass rounded-[32px] p-8">
            <h2 class="text-2xl font-black mb-6">Informasi Akun</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="glass rounded-2xl p-5">
                    <p class="text-slate-400 text-sm">Member Sejak</p>
                    <p class="font-bold mt-2">{{ $user->created_at->format('d M Y') }}</p>
                </div>
                <div class="glass rounded-2xl p-5">
                    <p class="text-slate-400 text-sm">Role</p>
                    <p class="font-bold mt-2">{{ ucfirst($user->role?->slug ?? 'user') }}</p>
                </div>
                <div class="glass rounded-2xl p-5">
                    <p class="text-slate-400 text-sm">Status</p>
                    <p class="font-bold mt-2 text-emerald-400">Active</p>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }
    </script>
@endpush
