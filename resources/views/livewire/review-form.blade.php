<div>
    @if($submitted)
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 text-center">
            <div class="text-3xl mb-2">🎉</div>
            <p class="font-semibold text-emerald-700">Terima kasih atas ulasanmu!</p>
            <p class="text-sm text-emerald-500 mt-1">Ulasan akan ditampilkan setelah diverifikasi admin.</p>
        </div>
    @else
        <div>
            <h3 class="font-semibold text-slate-700 mb-4">Tulis Ulasan</h3>

            @guest
                <div class="bg-brand-50 border border-brand-200 rounded-xl px-4 py-4 text-sm text-brand-700 text-center">
                    <a href="{{ route('login') }}" class="font-semibold underline hover:text-brand-900">Masuk</a>
                    terlebih dahulu untuk menulis ulasan.
                </div>
            @else
                <form wire:submit="submit" class="space-y-5">

                    @if($errors->has('general'))
                        <div class="bg-rose-50 border border-rose-200 rounded-xl px-4 py-3 text-sm text-rose-600">
                            {{ $errors->first('general') }}
                        </div>
                    @endif

                    {{-- Rating: Keseluruhan --}}
                    <div>
                        <label class="input-label">Rating Keseluruhan <span class="text-rose-400">*</span></label>
                        <div class="flex items-center gap-1 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="setRating('ratingOverall', {{ $i }})"
                                        class="text-2xl transition-all hover:scale-110 focus:outline-none {{ $ratingOverall >= $i ? 'text-amber-400' : 'text-slate-200' }}">★</button>
                            @endfor
                            <span class="ml-2 text-sm text-slate-400">
                                @if($ratingOverall === 1) Sangat Buruk
                                @elseif($ratingOverall === 2) Buruk
                                @elseif($ratingOverall === 3) Cukup
                                @elseif($ratingOverall === 4) Bagus
                                @elseif($ratingOverall === 5) Luar Biasa
                                @else Pilih rating
                                @endif
                            </span>
                        </div>
                        @error('ratingOverall') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rating: WiFi --}}
                    <div>
                        <label class="input-label">Kualitas WiFi <span class="text-rose-400">*</span></label>
                        <div class="flex items-center gap-1 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="setRating('ratingWifi', {{ $i }})"
                                        class="text-2xl transition-all hover:scale-110 focus:outline-none {{ $ratingWifi >= $i ? 'text-amber-400' : 'text-slate-200' }}">★</button>
                            @endfor
                        </div>
                        @error('ratingWifi') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rating: Kenyamanan --}}
                    <div>
                        <label class="input-label">Kenyamanan <span class="text-rose-400">*</span></label>
                        <div class="flex items-center gap-1 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="setRating('ratingComfort', {{ $i }})"
                                        class="text-2xl transition-all hover:scale-110 focus:outline-none {{ $ratingComfort >= $i ? 'text-amber-400' : 'text-slate-200' }}">★</button>
                            @endfor
                        </div>
                        @error('ratingComfort') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rating: Stop Kontak --}}
                    <div>
                        <label class="input-label">Ketersediaan Stop Kontak <span class="text-rose-400">*</span></label>
                        <div class="flex items-center gap-1 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="setRating('ratingSocket', {{ $i }})"
                                        class="text-2xl transition-all hover:scale-110 focus:outline-none {{ $ratingSocket >= $i ? 'text-amber-400' : 'text-slate-200' }}">★</button>
                            @endfor
                        </div>
                        @error('ratingSocket') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Komentar --}}
                    <div>
                        <label class="input-label">Komentar (opsional)</label>
                        <textarea wire:model="comment" rows="3"
                                  placeholder="Ceritakan pengalamanmu di sini..."
                                  class="input resize-none"></textarea>
                        @error('comment') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center">
                        <span wire:loading.remove wire:target="submit">Kirim Ulasan</span>
                        <span wire:loading wire:target="submit" class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Mengirim...
                        </span>
                    </button>
                </form>
            @endguest
        </div>
    @endif
</div>
