<x-layouts.app>
    <x-slot name="title">{{ $place->place_name }}</x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-brand-600">Beranda</a>
            <span>/</span>
            <a href="{{ route('places.index') }}" wire:navigate class="hover:text-brand-600">Jelajah</a>
            <span>/</span>
            <span class="text-slate-600 font-medium">{{ $place->place_name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kolom Kiri: Info Utama --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Cover Photo --}}
                <div class="relative h-72 rounded-2xl overflow-hidden bg-gradient-to-br from-brand-100 to-amber-100">
                    @if($place->cover_photo_url)
                        <img src="{{ asset('storage/'.$place->cover_photo_url) }}"
                             alt="{{ $place->place_name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-7xl opacity-30">
                                {{ $place->category === 'cafe' ? '☕' : ($place->category === 'coworking' ? '💼' : '📚') }}
                            </span>
                        </div>
                    @endif

                    {{-- Badge Sponsor --}}
                    @if($place->promos->isNotEmpty())
                        <div class="absolute top-4 left-4">
                            <span class="badge-sponsor text-sm px-3 py-1">✦ Konten Sponsor</span>
                        </div>
                    @endif
                </div>

                {{-- Info Header --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span class="badge-category mb-2 capitalize">{{ $place->category }}</span>
                            <h1 class="text-2xl font-bold text-slate-700 mt-1">{{ $place->place_name }}</h1>
                            <p class="text-slate-400 mt-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ $place->address }}, {{ $place->city }}
                            </p>
                        </div>
                        <livewire:favorite-toggle :place-id="$place->place_id" />
                    </div>

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-slate-100">
                        <div class="text-center">
                            <div class="flex items-center justify-center gap-1 text-amber-500 mb-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-bold text-slate-700">{{ $place->avg_overall ? number_format($place->avg_overall, 1) : '—' }}</span>
                            </div>
                            <p class="text-xs text-slate-400">{{ $place->total_reviews }} ulasan</p>
                        </div>
                        <div class="text-center">
                            <p class="font-bold text-slate-700 mb-1">
                                @if($place->price_range)
                                    @php [$min, $max] = explode('-', $place->price_range); @endphp
                                    Rp {{ number_format($min, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </p>
                            <p class="text-xs text-slate-400">Harga mulai</p>
                        </div>
                        <div class="text-center">
                            <p class="font-bold text-slate-700 mb-1">
                                <span class="capitalize">{{ $place->noise_level }}</span>
                            </p>
                            <p class="text-xs text-slate-400">Tingkat kebisingan</p>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-slate-700 mb-4">Fasilitas</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($place->facilities as $facility)
                            <div class="facility-chip">
                                <span>{{ $facility->label }}</span>
                                @if($facility->pivot->notes)
                                    <span class="text-slate-400 text-xs">({{ $facility->pivot->notes }})</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-slate-400 text-sm">Belum ada data fasilitas.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Deskripsi --}}
                @if($place->description)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-slate-700 mb-3">Tentang Tempat Ini</h2>
                        <p class="text-slate-500 leading-relaxed">{{ $place->description }}</p>
                    </div>
                @endif

                {{-- Rating Detail --}}
                @if($place->total_reviews > 0)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-slate-700 mb-4">Rata-rata Penilaian</h2>
                        <div class="space-y-3">
                            @foreach([
                                ['label' => 'WiFi', 'value' => $place->avg_wifi],
                                ['label' => 'Kenyamanan', 'value' => $place->verifiedReviews()->avg('rating_comfort')],
                                ['label' => 'Stop Kontak', 'value' => $place->verifiedReviews()->avg('rating_socket')],
                                ['label' => 'Keseluruhan', 'value' => $place->avg_overall],
                            ] as $r)
                                <div class="flex items-center gap-4">
                                    <span class="text-sm text-slate-500 w-24 flex-shrink-0">{{ $r['label'] }}</span>
                                    <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-brand-400 h-2 rounded-full transition-all"
                                             style="width: {{ ($r['value'] / 5) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-600 w-8 text-right">
                                        {{ $r['value'] ? number_format($r['value'], 1) : '—' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Ulasan --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-slate-700 mb-4">
                        Ulasan ({{ $place->total_reviews }})
                    </h2>

                    <div class="space-y-4 mb-6">
                        @forelse($place->verifiedReviews->take(5) as $review)
                            <div class="flex gap-4 pb-4 border-b border-slate-50 last:border-0 last:pb-0">
                                <div class="w-9 h-9 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-brand-700 font-semibold text-sm">
                                        {{ substr($review->user->full_name ?? 'A', 0, 1) }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-medium text-slate-700 text-sm">{{ $review->user->full_name ?? 'Anonim' }}</span>
                                        <div class="flex text-amber-400 text-xs">
                                            @for($i = 1; $i <= 5; $i++)
                                                {{ $i <= $review->rating_overall ? '★' : '☆' }}
                                            @endfor
                                        </div>
                                        <span class="text-slate-400 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-sm text-slate-500">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-400 text-sm text-center py-4">Belum ada ulasan. Jadilah yang pertama!</p>
                        @endforelse
                    </div>

                    {{-- Form Review --}}
                    @if(!$userHasReviewed)
                        <livewire:review-form :place-id="$place->place_id" />
                    @else
                        <div class="bg-brand-50 border border-brand-200 rounded-xl px-4 py-3 text-sm text-brand-700">
                            ✓ Kamu sudah memberikan ulasan untuk tempat ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kolom Kanan: Sidebar Info --}}
            <div class="space-y-5">

                {{-- Jam Buka --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h3 class="font-semibold text-slate-700 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jam Operasional
                    </h3>
                    <p class="text-slate-500 text-sm">{{ $place->opening_hours ?? 'Belum tersedia' }}</p>
                </div>

                {{-- Aksi --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
                    <h3 class="font-semibold text-slate-700 mb-1">Aksi</h3>
                    <a href="https://www.google.com/maps?q={{ $place->latitude }},{{ $place->longitude }}"
                       target="_blank"
                       onclick="logPlaceAction({{ $place->place_id }}, 'click_route')"
                       class="btn-primary w-full justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>

                {{-- Promo Aktif --}}
                @if($place->promos->isNotEmpty())
                    <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5">
                        <h3 class="font-semibold text-amber-700 mb-3 flex items-center gap-2">
                            🎉 Promo Aktif
                        </h3>
                        @foreach($place->promos as $promo)
                            <div class="mb-3 last:mb-0">
                                <p class="font-semibold text-amber-800 text-sm">{{ $promo->title }}</p>
                                @if($promo->description)
                                    <p class="text-amber-600 text-xs mt-1">{{ $promo->description }}</p>
                                @endif
                                <p class="text-amber-500 text-xs mt-1">
                                    Berlaku s/d {{ $promo->end_date->format('d M Y') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Embed Peta --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps?q={{ $place->latitude }},{{ $place->longitude }}&output=embed"
                        width="100%"
                        height="200"
                        style="border:0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
