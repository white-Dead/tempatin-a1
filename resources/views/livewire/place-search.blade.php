<div x-data="{
    init() {
        // Minta lokasi saat komponen diinisialisasi
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(
                (pos) => { $wire.setUserLocation(pos.coords.latitude, pos.coords.longitude); },
                () => {},
                { timeout: 6000, maximumAge: 300000 }
            );
        }
    }
}">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- ===== Panel Filter (Sidebar) ===== --}}
        <aside class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sticky top-20">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-semibold text-slate-700">Filter</h2>
                    <button wire:click="resetFilters" class="text-xs text-brand-500 hover:text-brand-700 font-medium">
                        Reset Semua
                    </button>
                </div>

                {{-- Search --}}
                <div class="mb-5">
                    <label class="input-label">Nama / Area</label>
                    <input type="text"
                           wire:model.live.debounce.400ms="search"
                           placeholder="Ketik nama atau kota..."
                           class="input">
                </div>

                {{-- Kota --}}
                <div class="mb-5">
                    <label class="input-label">Kota</label>
                    <select wire:model.live="city" class="input">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Fasilitas --}}
                <div class="mb-5">
                    <label class="input-label">Fasilitas</label>
                    <div class="space-y-2 mt-1">
                        @foreach($facilities as $f)
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox"
                                       wire:model.live="facilities"
                                       value="{{ $f->facility_name }}"
                                       class="rounded text-brand-500 border-slate-300 focus:ring-brand-400 focus:ring-offset-0">
                                <span class="text-sm text-slate-600 group-hover:text-brand-600 transition-colors">{{ $f->label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Suasana --}}
                <div class="mb-5">
                    <label class="input-label">Suasana</label>
                    <select wire:model.live="noiseLevel" class="input">
                        <option value="">Semua Suasana</option>
                        <option value="tenang">😌 Tenang</option>
                        <option value="sedang">😊 Sedang</option>
                        <option value="ramai">🎵 Ramai</option>
                    </select>
                </div>
                
                    {{-- AC only --}}
                    <label class="flex items-center gap-2.5 cursor-pointer p-3 mt-3 bg-white rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                        <input type="checkbox"
                               wire:model.live="hasAc"
                               class="rounded text-brand-500 border-slate-300 focus:ring-brand-400 focus:ring-offset-0">
                        <div>
                            <span class="text-sm font-medium text-slate-700">Hanya tempat dengan AC</span>
                            <p class="text-xs text-slate-400 mt-0.5">Tampilkan tempat yang menyediakan AC</p>
                        </div>
                    </label>

                {{-- Harga Maks --}}
                <div class="mb-5">
                    <label class="input-label">Harga Maksimum</label>
                    <select wire:model.live="priceMax" class="input">
                        <option value="">Semua Harga</option>
                        <option value="0">Gratis</option>
                        <option value="15000">s/d Rp 15.000</option>
                        <option value="25000">s/d Rp 25.000</option>
                        <option value="50000">s/d Rp 50.000</option>
                        <option value="100000">s/d Rp 100.000</option>
                    </select>
                </div>

                {{-- Nearby Toggle --}}
                <label class="flex items-center gap-2.5 cursor-pointer p-3 bg-brand-50 rounded-xl border border-brand-100 hover:bg-brand-100 transition-colors">
                    <input type="checkbox"
                           wire:model.live="nearbyOnly"
                           class="rounded text-brand-500 border-slate-300 focus:ring-brand-400 focus:ring-offset-0">
                    <div>
                        <span class="text-sm font-medium text-brand-700">Dalam 3 km dari saya</span>
                        <p class="text-xs text-brand-400 mt-0.5">Butuh akses lokasi</p>
                    </div>
                </label>

                {{-- WiFi only --}}
                <label class="flex items-center gap-2.5 cursor-pointer p-3 mt-3 bg-white rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                    <input type="checkbox"
                           wire:model.live="hasWifi"
                           class="rounded text-brand-500 border-slate-300 focus:ring-brand-400 focus:ring-offset-0">
                    <div>
                        <span class="text-sm font-medium text-slate-700">Hanya tempat dengan WiFi</span>
                        <p class="text-xs text-slate-400 mt-0.5">Tampilkan tempat yang menyediakan WiFi</p>
                    </div>
                </label>
            </div>
        </aside>

        {{-- ===== Hasil Pencarian ===== --}}
        <div class="lg:col-span-3">

            {{-- Header hasil --}}
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <span class="text-slate-600 font-medium">
                        <span class="text-brand-600 font-bold">{{ $places->count() }}</span> tempat ditemukan
                    </span>
                    <div wire:loading
                        wire:target="search,facilities,city,priceMax,noiseLevel,nearbyOnly,hasWifi,hasAc"
                        class="flex items-center gap-1.5 text-sm text-brand-500">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        Memuat...
                    </div>
                </div>
            </div>

            {{-- Active Filters --}}
            @if($search || $facilities || $city || $priceMax || $noiseLevel || $nearbyOnly)
                <div class="flex flex-wrap gap-2 mb-5">
                    @if($search)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-sm">
                            "{{ $search }}"
                            <button wire:click="$set('search', '')" class="hover:text-brand-900">✕</button>
                        </span>
                    @endif
                    @if($city)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-sm">
                            📍 {{ $city }}
                            <button wire:click="$set('city', '')" class="hover:text-brand-900">✕</button>
                        </span>
                    @endif
                    @if($noiseLevel)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-sm">
                            {{ ucfirst($noiseLevel) }}
                            <button wire:click="$set('noiseLevel', '')" class="hover:text-brand-900">✕</button>
                        </span>
                    @endif
                    @if($nearbyOnly)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-sm">
                            📍 Dekat saya
                            <button wire:click="$set('nearbyOnly', false)" class="hover:text-brand-900">✕</button>
                        </span>
                    @endif
                    @if($hasWifi)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-sm">
                            📶 Ada WiFi
                            <button wire:click="$set('hasWifi', false)" class="hover:text-brand-900">✕</button>
                        </span>
                    @endif
                    @if($hasAc)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-sm">
                            ❄️ Ada AC
                            <button wire:click="$set('hasAc', false)" class="hover:text-brand-900">✕</button>
                        </span>
                    @endif
                </div>
            @endif

            {{-- Daftar Tempat --}}
              <div wire:loading.class="opacity-50 pointer-events-none"
                  wire:target="search,facilities,city,priceMax,noiseLevel,nearbyOnly,hasWifi,hasAc"
                 class="grid grid-cols-1 sm:grid-cols-2 gap-5 transition-opacity duration-200">

                @forelse($places as $place)
                    <a href="{{ route('places.show', $place->place_id) }}"
                       wire:navigate
                       class="place-card group block {{ $place->promos->isNotEmpty() ? 'place-card-sponsored' : '' }}">

                        {{-- Gambar --}}
                        <div class="relative h-40 bg-gradient-to-br from-brand-100 to-amber-100 overflow-hidden">
                            @if($place->cover_photo_url)
                                <img src="{{ asset('storage/'.$place->cover_photo_url) }}"
                                     alt="{{ $place->place_name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-4xl opacity-30">
                                        {{ $place->category === 'cafe' ? '☕' : ($place->category === 'coworking' ? '💼' : '📚') }}
                                    </span>
                                </div>
                            @endif

                            <span class="absolute top-2 left-2 badge-category capitalize">{{ $place->category }}</span>

                            @if($place->promos->isNotEmpty())
                                <span class="absolute top-2 right-2 badge-sponsor">✦ Sponsor</span>
                            @endif

                            @if(isset($place->distance_km))
                                <span class="absolute bottom-2 right-2 bg-white/90 text-slate-600 text-xs font-medium px-2 py-0.5 rounded-full">
                                    {{ number_format($place->distance_km, 1) }} km
                                </span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-4">
                            <h3 class="font-semibold text-slate-700 truncate mb-0.5">{{ $place->place_name }}</h3>
                            <p class="text-xs text-slate-400 mb-3 truncate">📍 {{ $place->city }}</p>

                            {{-- Facilities --}}
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($place->facilities->take(3) as $f)
                                    <span class="facility-chip text-xs">{{ $f->label }}</span>
                                @endforeach
                                @if($place->facilities->count() > 3)
                                    <span class="facility-chip text-xs text-brand-500">
                                        +{{ $place->facilities->count() - 3 }}
                                    </span>
                                @endif
                            </div>

                            {{-- Rating & Score --}}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1 text-amber-400 text-xs">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="font-semibold text-slate-600">
                                        {{ $place->avg_overall ? number_format($place->avg_overall, 1) : '—' }}
                                    </span>
                                </div>
                                @if($place->price_range)
                                    @php [$min] = explode('-', $place->price_range); @endphp
                                    <span class="text-xs text-slate-400">
                                        Rp {{ number_format($min, 0, ',', '.') }}+
                                    </span>
                                @else
                                    <span class="text-xs text-emerald-500 font-medium">Gratis</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-2 py-20 text-center">
                        <div class="text-5xl mb-4">🔍</div>
                        <h3 class="text-lg font-semibold text-slate-600 mb-2">Tidak ada hasil</h3>
                        <p class="text-slate-400 text-sm">Coba ubah filter atau gunakan kata kunci lain.</p>
                        <button wire:click="resetFilters" class="btn-secondary mt-4 text-sm">
                            Reset Filter
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
