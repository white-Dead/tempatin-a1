<div>
    <button wire:click="toggle"
            title="{{ $isFavorite ? 'Hapus dari Favorit' : 'Simpan ke Favorit' }}"
            class="flex items-center justify-center w-9 h-9 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:ring-offset-1
                   {{ $isFavorite
                       ? 'bg-rose-50 text-rose-500 border border-rose-200 hover:bg-rose-100'
                       : 'bg-slate-50 text-slate-400 border border-slate-200 hover:bg-rose-50 hover:text-rose-400 hover:border-rose-200' }}">
        <svg class="w-5 h-5" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
    </button>
</div>
