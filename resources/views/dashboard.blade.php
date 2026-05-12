<x-layouts.app>
    <x-slot name="title">Dashboard</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-700">
                Halo, {{ auth()->user()->full_name }} 👋
            </h1>
            <p class="text-slate-400 mt-1">Selamat datang kembali di Tempatin!</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-5 mb-8">
            <a href="{{ route('places.index') }}" wire:navigate
               class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 hover:shadow-card-hover transition-all duration-200 group">
                <div class="text-3xl mb-3">🔍</div>
                <h3 class="font-semibold text-slate-700 mb-1">Cari Tempat</h3>
                <p class="text-sm text-slate-400">Temukan tempat produktif di sekitarmu</p>
            </a>
            <a href="{{ route('places.favorites') }}" wire:navigate
               class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 hover:shadow-card-hover transition-all duration-200 group">
                <div class="text-3xl mb-3">❤️</div>
                <h3 class="font-semibold text-slate-700 mb-1">Favorit Saya</h3>
                <p class="text-sm text-slate-400">{{ auth()->user()->favorites()->count() }} tempat tersimpan</p>
            </a>
            <div class="bg-gradient-to-br from-brand-50 to-amber-50 rounded-2xl border border-brand-100 shadow-sm p-5">
                <div class="text-3xl mb-3">✍️</div>
                <h3 class="font-semibold text-slate-700 mb-1">Ulasan Saya</h3>
                <p class="text-sm text-slate-400">{{ auth()->user()->reviews()->count() }} ulasan ditulis</p>
            </div>
            <a href="{{ route('subscriptions.index') }}" wire:navigate
               class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 hover:shadow-card-hover transition-all duration-200 group">
                <div class="text-base font-bold text-brand-500 mb-3">Premium</div>
                <h3 class="font-semibold text-slate-700 mb-1">Langganan</h3>
                <p class="text-sm text-slate-400">
                    {{ auth()->user()->isPremium() ? 'Premium aktif' : 'Hilangkan iklan' }}
                </p>
            </a>
        </div>

        <div class="bg-brand-50 border border-brand-200 rounded-2xl p-6 flex items-center gap-4">
            <span class="text-3xl">💼</span>
            <div class="flex-1">
                <h3 class="font-semibold text-brand-700">Punya tempat usaha?</h3>
                <p class="text-sm text-brand-500 mt-0.5">Daftarkan ke Tempatin dan jangkau lebih banyak pengguna produktif.</p>
            </div>
            <a href="#" class="btn-primary text-sm flex-shrink-0">Daftar Mitra</a>
        </div>
    </div>
</x-layouts.app>
