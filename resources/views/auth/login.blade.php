v<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vokatif</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background:
                radial-gradient(circle at top left, #7c3aed, transparent 30%),
                radial-gradient(circle at bottom right, #06b6d4, transparent 30%),
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
        <h1 class="text-7xl font-black leading-tight">Modern Event Ticketing Platform</h1>
        <p class="text-slate-400 text-xl mt-8 leading-relaxed">
            Platform manajemen event dan ticketing modern berbasis Laravel API,
            JWT Authentication, API Key, Basic Auth, dan QR Check-in.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="glass rounded-[40px] p-10">

        <h2 class="text-4xl font-black mb-3">Login Account</h2>
        <p class="text-slate-400 mb-10">Masuk ke dashboard Vokatif.</p>

        <form action="/login" method="POST" class="space-y-6">
            @csrf

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
            </div>

            <div>
                <label class="block mb-3 text-slate-300">Password</label>
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="w-full rounded-2xl bg-white/5 border border-white/10 px-5 py-4 outline-none focus:border-cyan-400 pr-14"
                        placeholder="Masukkan password"
                        required
                    >
                    <button type="button"
                            onclick="togglePassword('password', 'eyeIcon')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            @error('email')
                <div class="bg-red-500/10 border border-red-500/20 text-red-300 px-5 py-4 rounded-2xl">
                    {{ $message }}
                </div>
            @enderror

            <button class="w-full bg-gradient-to-r from-violet-600 to-cyan-500 rounded-2xl py-5 font-black text-xl hover:scale-[1.02] transition flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Login
            </button>

        </form>

        <!-- REGISTER LINK -->
        <div class="mt-8 text-center">
            <p class="text-slate-400">
                Belum punya akun?
                <a href="/register" class="text-cyan-400 font-bold hover:text-cyan-300 transition">
                    Daftar sekarang →
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
