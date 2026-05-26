<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Mitra' }} — Tempatin Mitra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-slate-50" x-data>
    <div class="flex h-full">
        <aside class="w-60 bg-white border-r border-slate-100 flex-shrink-0 flex flex-col">
            <div class="p-5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-brand rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">T</span>
                    </div>
                    <div>
                        <span class="font-bold text-slate-700 text-sm">Tempatin</span>
                        <p class="text-xs text-slate-400">Dashboard Mitra</p>
                    </div>
                </div>
            </div>
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('partner.dashboard') }}" wire:navigate
                   class="{{ request()->routeIs('partner.dashboard') ? 'flex items-center gap-3 px-3 py-2.5 bg-brand-50 text-brand-700 rounded-xl font-semibold text-sm' : 'flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 rounded-xl text-sm' }}">
                    Dashboard
                </a>
                <a href="{{ route('partner.place.create') }}" wire:navigate
                   class="{{ request()->routeIs('partner.place.create') ? 'flex items-center gap-3 px-3 py-2.5 bg-brand-50 text-brand-700 rounded-xl font-semibold text-sm' : 'flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 rounded-xl text-sm' }}">
                    + Tambah Tempat
                </a>
                <a href="{{ route('partner.pos.index') }}" wire:navigate
                   class="{{ request()->routeIs('partner.pos.*') ? 'flex items-center gap-3 px-3 py-2.5 bg-brand-50 text-brand-700 rounded-xl font-semibold text-sm' : 'flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 rounded-xl text-sm' }}">
                    Integrasi Kasir
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 rounded-xl text-sm">
                    Lihat Situs
                </a>
            </nav>
            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-rose-400 hover:bg-rose-50 rounded-xl text-sm">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>
        <div class="flex-1 flex flex-col overflow-auto">
            <header class="bg-white border-b border-slate-100 px-8 py-4 flex-shrink-0">
                <h1 class="font-semibold text-slate-700">{{ $title ?? 'Dashboard' }}</h1>
            </header>
            <main class="flex-1 p-8">
                @if(session('success'))
                    <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
