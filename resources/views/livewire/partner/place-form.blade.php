<div>
    <form wire:submit="save" class="space-y-6 max-w-2xl">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Nama & Kategori --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="input-label">Nama Tempat <span class="text-rose-400">*</span></label>
                <input type="text" wire:model="placeName" class="input" placeholder="Contoh: Kafe Produktif Jogja">
                @error('placeName') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="input-label">Kategori <span class="text-rose-400">*</span></label>
                <select wire:model="category" class="input">
                    <option value="cafe">Kafe</option>
                    <option value="coworking">Coworking Space</option>
                    <option value="restoran">Restoran</option>
                    <option value="perpustakaan">Perpustakaan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                @error('category') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Alamat & Kota --}}
        <div>
            <label class="input-label">Alamat Lengkap <span class="text-rose-400">*</span></label>
            <textarea wire:model="address" rows="2" class="input resize-none"
                      placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan"></textarea>
            @error('address') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="input-label">Kota <span class="text-rose-400">*</span></label>
                <input type="text" wire:model="city" class="input" placeholder="Yogyakarta">
                @error('city') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="input-label">Latitude <span class="text-rose-400">*</span></label>
                <input type="number" wire:model="latitude" step="0.000001" class="input" placeholder="-7.79560">
                @error('latitude') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="input-label">Longitude <span class="text-rose-400">*</span></label>
                <input type="number" wire:model="longitude" step="0.000001" class="input" placeholder="110.36952">
                @error('longitude') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <p class="text-xs text-slate-400 -mt-2">
            💡 Cara mudah cari koordinat: buka Google Maps, klik kanan lokasi → salin koordinat.
        </p>

        {{-- Harga & Jam Buka --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="input-label">Rentang Harga</label>
                <input type="text" wire:model="priceRange" class="input" placeholder="10000-35000">
                <p class="text-xs text-slate-400 mt-1">Format: min-max (contoh: 10000-35000). Isi 0-0 jika gratis.</p>
                @error('priceRange') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="input-label">Jam Operasional</label>
                <input type="text" wire:model="openingHours" class="input" placeholder="08:00-22:00">
                @error('openingHours') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Suasana --}}
        <div>
            <label class="input-label">Tingkat Kebisingan <span class="text-rose-400">*</span></label>
            <div class="flex gap-3 mt-1">
                @foreach(['tenang' => '😌 Tenang', 'sedang' => '😊 Sedang', 'ramai' => '🎵 Ramai'] as $val => $label)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" wire:model="noiseLevel" value="{{ $val }}" class="sr-only">
                        <div class="{{ $noiseLevel === $val
                                ? 'border-2 border-brand-400 bg-brand-50 text-brand-700'
                                : 'border border-slate-200 bg-white text-slate-500 hover:bg-slate-50' }}
                             rounded-xl px-3 py-2.5 text-sm font-medium text-center transition-all duration-150">
                            {{ $label }}
                        </div>
                    </label>
                @endforeach
            </div>
            @error('noiseLevel') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="input-label">Deskripsi</label>
            <textarea wire:model="description" rows="4" class="input resize-none"
                      placeholder="Ceritakan keunggulan tempat ini..."></textarea>
            @error('description') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Fasilitas --}}
        <div>
            <label class="input-label">Fasilitas yang Tersedia</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
                @foreach($allFacilities as $f)
                    <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all duration-150
                                  {{ in_array($f->facility_id, $selectedFacilities)
                                      ? 'border-brand-300 bg-brand-50 text-brand-700'
                                      : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                        <input type="checkbox"
                               wire:model.live="selectedFacilities"
                               value="{{ $f->facility_id }}"
                               class="rounded text-brand-500 border-slate-300 focus:ring-brand-400 focus:ring-offset-0">
                        <span class="text-sm font-medium">{{ $f->label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Foto --}}
        <div>
            <label class="input-label">Foto Tempat (maks. 3MB per foto)</label>
            <div class="mt-2 border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-brand-300 transition-colors">
                <input type="file" wire:model="photos" multiple accept="image/*" class="hidden" id="photo-upload">
                <label for="photo-upload" class="cursor-pointer">
                    <div class="text-3xl mb-2">📷</div>
                    <p class="text-slate-500 text-sm">Klik untuk pilih foto atau drag & drop</p>
                    <p class="text-slate-400 text-xs mt-1">JPG, PNG, WebP — maks 3MB per file</p>
                </label>
            </div>
            <div wire:loading wire:target="photos" class="text-sm text-brand-500 mt-2">Mengupload foto...</div>
            @error('photos.*') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Submit --}}
        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">
                <span wire:loading.remove wire:target="save">
                    {{ $placeId ? 'Simpan Perubahan' : 'Daftarkan Tempat' }}
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    Menyimpan...
                </span>
            </button>
            <a href="{{ route('partner.dashboard') }}" wire:navigate class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
