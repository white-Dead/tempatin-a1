<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — Tempatin Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-slate-50" x-data>

    <div class="flex h-full">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-slate-100 flex-shrink-0 flex flex-col">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-brand rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">T</span>
                    </div>
                    <div>
                        <span class="font-bold text-slate-700">Tempatin</span>
                        <p class="text-xs text-slate-400">Panel Admin</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                   class="{{ request()->routeIs('admin.dashboard') ? 'flex items-center gap-3 px-3 py-2.5 bg-brand-50 text-brand-700 rounded-xl font-semibold' : 'flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-700 rounded-xl' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.places.index') }}" wire:navigate
                   class="{{ request()->routeIs('admin.places.*') ? 'flex items-center gap-3 px-3 py-2.5 bg-brand-50 text-brand-700 rounded-xl font-semibold' : 'flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-700 rounded-xl' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    Moderasi Tempat
                </a>
                <a href="{{ route('admin.reviews') }}" wire:navigate
                   class="{{ request()->routeIs('admin.reviews') ? 'flex items-center gap-3 px-3 py-2.5 bg-brand-50 text-brand-700 rounded-xl font-semibold' : 'flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-700 rounded-xl' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3z"/>
                    </svg>
                    Moderasi Ulasan
                </a>
                <a href="{{ route('admin.partners') }}" wire:navigate
                   class="{{ request()->routeIs('admin.partners') ? 'flex items-center gap-3 px-3 py-2.5 bg-brand-50 text-brand-700 rounded-xl font-semibold' : 'flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-700 rounded-xl' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Data Mitra
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2.5 text-rose-400 hover:bg-rose-50 rounded-xl text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-auto">
            <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
                <h1 class="text-lg font-semibold text-slate-700">{{ $title ?? 'Dashboard' }}</h1>
                <span class="text-sm text-slate-400">{{ auth()->user()->full_name }}</span>
            </header>

            <main class="flex-1 p-8 overflow-auto">
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('info'))
                    <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-sky-50 border border-sky-200 text-sky-700 rounded-xl text-sm font-medium">
                        {{ session('info') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
