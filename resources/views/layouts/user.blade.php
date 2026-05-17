<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Vokatif</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
    </style>
</head>

<body class="min-h-screen">

    @php $role = auth()->user()?->role?->slug; @endphp

    <!-- HEADER -->
    @include('partials.header')

    <!-- CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-12">
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('partials.footer')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>
