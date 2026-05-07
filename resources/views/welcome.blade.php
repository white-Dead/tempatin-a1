<x-layouts.app>
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-orange-50 via-white to-amber-50 pt-16 pb-24">
        {{-- Decorative blobs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-100 rounded-full blur-3xl opacity-30 -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-amber-100 rounded-full blur-3xl opacity-40 translate-y-1/2 -translate-x-1/2"></div>
        </div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-50 border border-brand-200 rounded-full text-sm text-brand-700 font-medium mb-6">
                <span class="w-2 h-2 bg-brand-500 rounded-full animate-pulse"></span>
                Platform #1 Tempat Produktif Indonesia
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Temukan Tempat <br>
                <span class="text-gradient-brand">Produktif Terbaikmu</span>
            </h1>

            <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Cari kafe, coworking space, dan perpustakaan dengan WiFi kencang, stop kontak banyak,
                dan suasana yang bikin kamu fokus. Direkomendasikan berdasarkan kebutuhanmu.
            </p>

            {{-- Search Box --}}
            <form action="{{ route('places.index') }}" method="GET"
                  class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
                <input type="text" name="q"
                       placeholder="Cari kafe, coworking space, atau kota..."
                       class="input flex-1 text-base shadow-sm">
                <button type="submit" class="btn-primary text-base px-6 py-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            </form>

            {{-- Quick stats --}}
            <div class="flex items-center justify-center gap-8 mt-12">
                <div class="text-center">
                    <p class="text-2xl font-bold text-brand-600">{{ \App\Models\Place::where('status','active')->count() }}+</p>
                    <p class="text-sm text-slate-500">Tempat Aktif</p>
                </div>
                <div class="w-px h-8 bg-slate-200"></div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-brand-600">{{ \App\Models\Review::where('is_verified',true)->count() }}+</p>
                    <p class="text-sm text-slate-500">Ulasan Terverifikasi</p>
                </div>
                <div class="w-px h-8 bg-slate-200"></div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-brand-600">{{ \App\Models\Place::where('status','active')->distinct()->count('city') }}+</p>
                    <p class="text-sm text-slate-500">Kota</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Category Shortcuts --}}
    <section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach([
                ['label' => 'Kafe', 'category' => 'cafe', 'emoji' => '☕', 'bg' => 'bg-amber-50 border-amber-200 hover:bg-amber-100'],
                ['label' => 'Coworking', 'category' => 'coworking', 'emoji' => '💼', 'bg' => 'bg-sky-50 border-sky-200 hover:bg-sky-100'],
                ['label' => 'Perpustakaan', 'category' => 'perpustakaan', 'emoji' => '📚', 'bg' => 'bg-emerald-50 border-emerald-200 hover:bg-emerald-100'],
                ['label' => 'Restoran', 'category' => 'restoran', 'emoji' => '🍽️', 'bg' => 'bg-rose-50 border-rose-200 hover:bg-rose-100'],
            ] as $cat)
                <a href="{{ route('places.index') }}?category={{ $cat['category'] }}"
                   class="flex items-center gap-3 px-5 py-4 {{ $cat['bg'] }} border rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md">
                    <span class="text-2xl">{{ $cat['emoji'] }}</span>
                    <span class="font-semibold text-slate-700">{{ $cat['label'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured Places --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-700">Tempat Pilihan</h2>
                <p class="text-slate-500 text-sm mt-1">Direkomendasikan berdasarkan kelengkapan fasilitas</p>
            </div>
            <a href="{{ route('places.index') }}" class="btn-secondary text-sm">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featured as $place)
                <a href="{{ route('places.show', $place->place_id) }}" class="place-card group block animate-fade-slide-up">
                    {{-- Cover --}}
                    <div class="relative h-44 bg-gradient-to-br from-brand-100 to-amber-100 overflow-hidden">
                        @if($place->cover_photo_url)
                            <img src="{{ asset('storage/'.$place->cover_photo_url) }}"
                                 alt="{{ $place->place_name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-5xl opacity-40">
                                    {{ $place->category === 'cafe' ? '☕' : ($place->category === 'coworking' ? '💼' : '📚') }}
                                </span>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 badge-category capitalize">{{ $place->category }}</span>
                        @if($place->promos->isNotEmpty())
                            <span class="absolute top-3 right-3 badge-sponsor">✦ Sponsor</span>
                        @endif
                    </div>

                    <div class="p-5">
                        <h3 class="font-semibold text-slate-700 mb-1 truncate">{{ $place->place_name }}</h3>
                        <p class="text-sm text-slate-400 mb-3">📍 {{ $place->city }}</p>

                        {{-- Facilities --}}
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach($place->facilities->take(4) as $f)
                                <span class="facility-chip">{{ $f->label }}</span>
                            @endforeach
                            @if($place->facilities->count() > 4)
                                <span class="facility-chip text-brand-500">+{{ $place->facilities->count() - 4 }}</span>
                            @endif
                        </div>

                        {{-- Rating & Price --}}
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-1 text-amber-500">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-medium text-slate-600">
                                    {{ $place->avg_overall ? number_format($place->avg_overall, 1) : '—' }}
                                </span>
                                <span class="text-slate-400">({{ $place->total_reviews }})</span>
                            </div>
                            @if($place->price_range)
                                <span class="text-slate-400">
                                    Rp {{ number_format(explode('-', $place->price_range)[0], 0, ',', '.') }}+
                                </span>
                            @else
                                <span class="text-emerald-500 font-medium text-xs">Gratis</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">
                    Belum ada tempat yang tersedia. Nantikan update kami!
                </div>
            @endforelse
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 mb-4">
        <div class="bg-gradient-brand rounded-3xl p-10 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm rounded-3xl"></div>
            <div class="relative">
                <h2 class="text-3xl font-bold mb-3">Punya Kafe atau Coworking Space?</h2>
                <p class="text-white/80 mb-6 text-lg">
                    Daftarkan tempat usahamu ke Tempatin dan jangkau ribuan mahasiswa dan pekerja produktif.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-brand-600 font-bold rounded-xl hover:bg-brand-50 transition-colors shadow-md">
                    Daftar Sebagai Mitra
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
