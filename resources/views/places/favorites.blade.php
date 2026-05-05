<x-layouts.app>
    <x-slot name="title">Tempat Favoritku</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-slate-700 mb-6">Tempat Favoritku ❤️</h1>

        @if($places->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl border border-slate-100">
                <div class="text-5xl mb-4">💔</div>
                <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada favorit</h3>
                <p class="text-slate-400 text-sm mb-6">Tekan tombol ❤️ di halaman tempat untuk menyimpannya di sini.</p>
                <a href="{{ route('places.index') }}" wire:navigate class="btn-primary">Cari Tempat</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($places as $place)
                    <a href="{{ route('places.show', $place->place_id) }}" wire:navigate class="place-card block">
                        <div class="h-40 bg-gradient-to-br from-brand-100 to-amber-100 flex items-center justify-center">
                            <span class="text-4xl opacity-30">
                                {{ $place->category === 'cafe' ? '☕' : ($place->category === 'coworking' ? '💼' : '📚') }}
                            </span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-slate-700 truncate">{{ $place->place_name }}</h3>
                            <p class="text-xs text-slate-400 mt-0.5">📍 {{ $place->city }}</p>
                            <div class="flex flex-wrap gap-1 mt-3">
                                @foreach($place->facilities->take(3) as $f)
                                    <span class="facility-chip text-xs">{{ $f->label }}</span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">{{ $places->links() }}</div>
        @endif
    </div>
</x-layouts.app>
