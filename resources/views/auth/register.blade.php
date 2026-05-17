<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Vokatif</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background:
                radial-gradient(circle at top right, #7c3aed, transparent 30%),
                radial-gradient(circle at bottom left, #06b6d4, transparent 30%),
                #020617;
            color: white;
        }
        .glass {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-6xl grid lg:grid-cols-2 gap-10 items-center">

    <!-- LEFT -->
    <div>
        <p class="uppercase tracking-[6px] text-cyan-400 mb-6">Vokatif Platform</p>
        <h1 class="text-7xl font-black leading-tight">Bergabung dengan Vokatif</h1>
        <p class="text-slate-400 text-xl mt-8 leading-relaxed">
            Buat akun dan mulai temukan event terbaik,
            beli tiket, dan nikmati pengalaman check-in modern.
        </p>
        <div class="mt-10 space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-violet-500/20 flex items-center justify-center text-violet-400 font-black">1</div>
                <p class="text-slate-300">Buat akun gratis dalam hitungan detik</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-cyan-500/20 flex items-center justify-center text-cyan-400 font-black">2</div>
                <p class="text-slate-300">Jelajahi ratusan event pilihan</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-fuchsia-500/20 flex items-center justify-center text-fuchsia-400 font-black">3</div>
                <p class="text-slate-300">Beli tiket dan dapatkan QR Code instan</p>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="glass rounded-[40px] p-10">

        <h2 class="text-4xl font-black mb-3">Buat Akun</h2>
        <p class="text-slate-400 mb-10">Daftar dan mulai eksplorasi event.</p>

        <form action="/register" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block mb-3 text-slate-300">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400"
                    placeholder="Masukkan nama lengkap"
                    required
                >
                @error('name')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-3 text-slate-300">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400"
                    placeholder="Masukkan email"
                    required
                >
                @error('email')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-3 text-slate-300">Password</label>
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400 pr-14"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    <button type="button"
                            onclick="togglePassword('password', 'eyeIcon1')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition">
                        <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-3 text-slate-300">Konfirmasi Password</label>
                <div class="relative">
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400 pr-14"
                        placeholder="Ulangi password"
                        required
                    >
                    <button type="button"
                            onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition">
                        <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button class="w-full bg-gradient-to-r from-violet-600 to-cyan-500 rounded-2xl py-5 font-black text-xl hover:scale-[1.02] transition flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Daftar Sekarang
            </button>

        </form>

        <!-- LOGIN LINK -->
        <div class="mt-8 text-center">
            <p class="text-slate-400">
                Sudah punya akun?
                <a href="/login" class="text-cyan-400 font-bold hover:text-cyan-300 transition">
                    Login di sini →
                </a>
            </p>
        </div>

    </div>

</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}
</script>

</body>
</html>
