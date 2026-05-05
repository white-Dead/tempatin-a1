<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-700">Tempat Saya</h2>
            <p class="text-sm text-slate-400">{{ $stats->count() }} tempat terdaftar</p>
        </div>
        <a href="{{ route('partner.place.create') }}" wire:navigate class="btn-primary">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Tempat
        </a>
    </div>

    @if($stats->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <div class="text-5xl mb-4">🏪</div>
            <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada tempat</h3>
            <p class="text-slate-400 text-sm mb-6">Daftarkan tempat usahamu dan mulai jangkau ribuan pengguna produktif.</p>
            <a href="{{ route('partner.place.create') }}" wire:navigate class="btn-primary">Daftarkan Tempat Pertama</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            @foreach($stats as $item)
                @php $place = $item['place']; @endphp
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-slate-700 truncate">{{ $place->place_name }}</h3>
                            <p class="text-sm text-slate-400">{{ $place->city }} · <span class="capitalize">{{ $place->category }}</span></p>
                        </div>
                        @switch($place->status)
                            @case('active')   <span class="badge-active flex-shrink-0">Aktif</span> @break
                            @case('pending_review') <span class="badge-pending flex-shrink-0">Menunggu</span> @break
                            @case('inactive') <span class="badge-inactive flex-shrink-0">Nonaktif</span> @break
                        @endswitch
                    </div>

                    {{-- Stats 7 hari --}}
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-slate-50 rounded-xl p-3 text-center">
                            <p class="text-xl font-bold text-brand-600">{{ number_format($item['views_7d']) }}</p>
                            <p class="text-xs text-slate-400">Kunjungan (7 hari)</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 text-center">
                            <p class="text-xl font-bold text-brand-600">{{ number_format($item['routes_7d']) }}</p>
                            <p class="text-xs text-slate-400">Klik Rute (7 hari)</p>
                        </div>
                    </div>

                    {{-- Kelengkapan data --}}
                    <div class="mb-4">
                        <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                            <span>Kelengkapan data</span>
                            <span class="font-semibold">{{ $place->data_completeness_score }}%</span>
                        </div>
                        <div class="bg-slate-100 rounded-full h-2">
                            <div class="bg-brand-400 h-2 rounded-full transition-all"
                                 style="width: {{ $place->data_completeness_score }}%"></div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('partner.place.edit', $place->place_id) }}" wire:navigate
                           class="btn-secondary text-sm flex-1 justify-center">Edit</a>
                        <a href="{{ route('places.show', $place->place_id) }}" wire:navigate
                           class="btn-ghost text-sm">Lihat</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
