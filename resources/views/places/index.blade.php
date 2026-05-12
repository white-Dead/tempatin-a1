<x-layouts.app>
    <x-slot name="title">Jelajah Tempat</x-slot>

    <div class="bg-gradient-to-b from-orange-50 to-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-slate-700 mb-1">Jelajah Tempat Produktif</h1>
            <p class="text-slate-500">Filter dan temukan tempat yang paling cocok dengan kebutuhanmu.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @unless(auth()->check() && auth()->user()->isPremium())
            {{-- Advertisement Slot --}}
            <section class="mb-8" aria-label="Iklan">
                <div class="relative overflow-hidden rounded-2xl border border-dashed border-brand-200 bg-gradient-to-r from-brand-50 via-white to-amber-50 p-5 sm:p-6">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white text-brand-600 shadow-sm ring-1 ring-brand-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-2.634 1.529L5.5 19.131A3 3 0 014 16.529V7.471a3 3 0 011.5-2.602l2.866-1.638A1.76 1.76 0 0111 4.76v1.122zm0 0l6.053-2.421A1.4 1.4 0 0119 4.761v14.478a1.4 1.4 0 01-1.947 1.3L11 18.118M8 8v8" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-brand-500">Slot Iklan</p>
                                <h2 class="mt-1 text-xl font-bold text-slate-700">Tampilkan promo di halaman Jelajah</h2>
                                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">
                                    Area ini disiapkan untuk banner sponsor, promo tempat, atau kampanye mitra yang ingin tampil saat pengguna mencari lokasi produktif.
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('register') }}" class="btn-primary inline-flex justify-center text-sm sm:flex-shrink-0">
                            Pasang Iklan
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
        @endunless

        <livewire:place-search />
    </div>
</x-layouts.app>
