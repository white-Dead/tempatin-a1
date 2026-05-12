<x-layouts.app>
    <x-slot name="title">Langganan Premium</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-brand-500">Tempatin Premium</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-700">Nikmati Tempatin tanpa iklan</h1>
            <p class="mt-3 max-w-2xl text-slate-500 leading-relaxed">
                Akun premium tidak akan melihat slot iklan di beranda dan halaman Jelajah selama langganan aktif.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <section class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-700">Paket Bulanan</h2>
                        <p class="mt-1 text-sm text-slate-500">Cocok untuk pengguna aktif yang sering mencari tempat produktif.</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-brand-600">Rp {{ number_format($price, 0, ',', '.') }}</p>
                        <p class="text-sm text-slate-400">per bulan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-6">
                    @foreach([
                        'Slot iklan disembunyikan',
                        'Pengalaman jelajah lebih fokus',
                        'Status premium tersimpan di akun',
                        'Masa aktif 1 bulan per aktivasi',
                    ] as $benefit)
                        <div class="flex items-center gap-3 rounded-xl bg-slate-50 px-4 py-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-600">✓</span>
                            <span class="text-sm font-medium text-slate-600">{{ $benefit }}</span>
                        </div>
                    @endforeach
                </div>

                @if(auth()->user()->isPremium())
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        Premium aktif sampai {{ auth()->user()->premium_ends_at->format('d M Y H:i') }}.
                    </div>
                @endif
            </section>

            <aside class="bg-brand-50 rounded-2xl border border-brand-100 p-6">
                <h2 class="text-lg font-bold text-brand-700">Status Akun</h2>
                <p class="mt-2 text-sm text-brand-500">
                    {{ auth()->user()->isPremium() ? 'Akun kamu sedang premium.' : 'Akun kamu belum premium.' }}
                </p>

                <form method="POST" action="{{ route('subscriptions.activate') }}" class="mt-6">
                    @csrf
                    <button type="submit" class="btn-primary w-full justify-center">
                        {{ auth()->user()->isPremium() ? 'Perpanjang 1 Bulan' : 'Aktifkan Premium' }}
                    </button>
                </form>

                @if(auth()->user()->isPremium())
                    <form method="POST" action="{{ route('subscriptions.cancel') }}" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary w-full justify-center">
                            Berhenti Langganan
                        </button>
                    </form>
                @endif

                <p class="mt-4 text-xs leading-relaxed text-brand-400">
                    Tombol ini menyiapkan alur awal langganan. Integrasi pembayaran bisa ditambahkan pada tahap berikutnya.
                </p>
            </aside>
        </div>
    </div>
</x-layouts.app>
