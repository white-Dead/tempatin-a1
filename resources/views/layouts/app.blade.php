<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f97316">
    <link rel="manifest" href="/manifest.json">

    <title>{{ $title ?? config('app.name', 'Tempatin') }} — Temukan Tempat Produktifmu</title>
    <meta name="description" content="{{ $description ?? 'Tempatin membantu kamu menemukan kafe, coworking space, dan tempat produktif terbaik di sekitarmu.' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-white" x-data>

    {{-- Toast Container --}}
    <div class="fixed top-4 right-4 z-50 space-y-2" x-data x-show="$store.toast.messages.length > 0">
        <template x-for="toast in $store.toast.messages" :key="toast.id">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-medium animate-fade-slide-up"
                 :class="toast.type === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200'">
                <span x-text="toast.msg"></span>
                <button @click="$store.toast.remove(toast.id)" class="ml-2 opacity-60 hover:opacity-100">✕</button>
            </div>
        </template>
    </div>

    {{-- Navbar --}}
    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-brand rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">T</span>
                    </div>
                    <span class="text-xl font-bold text-gradient-brand">Tempatin</span>
                </a>

                {{-- Nav Links (desktop) --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'nav-link-active' : 'nav-link' }}">Beranda</a>
                    <a href="{{ route('places.index') }}" wire:navigate
                       class="{{ request()->routeIs('places.index') ? 'nav-link-active' : 'nav-link' }}">Jelajah</a>
                    @auth
                        <a href="{{ route('places.favorites') }}" wire:navigate
                           class="{{ request()->routeIs('places.favorites') ? 'nav-link-active' : 'nav-link' }}">Favorit</a>
                    @endauth
                </div>

                {{-- Auth Area --}}
                <div class="flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" wire:navigate class="btn-ghost text-sm">Masuk</a>
                        <a href="{{ route('register') }}" wire:navigate class="btn-primary text-sm py-2">Daftar</a>
                    @else
                        {{-- User Menu --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50 transition-colors">
                                <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center">
                                    <span class="text-brand-700 font-semibold text-sm">
                                        {{ substr(auth()->user()->full_name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-slate-600">
                                    {{ auth()->user()->full_name }}
                                </span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" x-transition @click.outside="open = false"
                                 class="absolute right-0 mt-2 w-52 bg-white border border-slate-100 rounded-2xl shadow-lg py-2 z-50">

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" wire:navigate
                                       class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                        Panel Admin
                                    </a>
                                @endif

                                @if(auth()->user()->isPartner())
                                    <a href="{{ route('partner.dashboard') }}" wire:navigate
                                       class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        Dashboard Mitra
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-rose-500 hover:bg-rose-50 text-left">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-50 border-t border-slate-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 bg-gradient-brand rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xs">T</span>
                        </div>
                        <span class="text-lg font-bold text-gradient-brand">Tempatin</span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Platform rekomendasi tempat produktif untuk mahasiswa dan pekerja remote Indonesia.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-600 mb-3">Jelajah</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="{{ route('places.index') }}" class="hover:text-brand-600 transition-colors">Semua Tempat</a></li>
                        <li><a href="{{ route('places.index') }}?category=cafe" class="hover:text-brand-600 transition-colors">Kafe</a></li>
                        <li><a href="{{ route('places.index') }}?category=coworking" class="hover:text-brand-600 transition-colors">Coworking Space</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-600 mb-3">Mitra</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-brand-600 transition-colors">Daftarkan Tempat</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-colors">Paket Sponsor</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-200 mt-8 pt-6 text-center text-sm text-slate-400">
                © {{ date('Y') }} Tempatin. Dibuat dengan ❤️ untuk produktivitas Indonesia.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
