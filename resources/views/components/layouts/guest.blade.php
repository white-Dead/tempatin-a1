<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Masuk' }} — Tempatin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-amber-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-brand rounded-xl flex items-center justify-center shadow-md">
                    <span class="text-white font-bold">T</span>
                </div>
                <span class="text-2xl font-bold text-gradient-brand">Tempatin</span>
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
            {{ $slot }}
        </div>

        {{-- Back --}}
        <p class="text-center mt-6 text-sm text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">← Kembali ke beranda</a>
        </p>
    </div>

    @livewireScripts
</body>
</html>
