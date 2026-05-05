<div>
    {{-- Filter Bar --}}
    <div class="flex flex-col sm:flex-row gap-4 mb-6">
        <input type="text"
               wire:model.live.debounce.300ms="search"
               placeholder="Cari nama tempat atau kota..."
               class="input flex-1">

        <select wire:model.live="statusFilter" class="input w-auto">
            <option value="">Semua Status</option>
            <option value="pending_review">Menunggu Review</option>
            <option value="active">Aktif</option>
            <option value="inactive">Ditolak/Nonaktif</option>
        </select>
    </div>

    {{-- Loading --}}
    <div wire:loading wire:target="search,statusFilter" class="mb-4 text-sm text-brand-500 flex items-center gap-2">
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
        Memuat...
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600">Nama Tempat</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600 hidden md:table-cell">Kota</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600 hidden lg:table-cell">Mitra</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600">Status</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600 hidden md:table-cell">Kelengkapan</th>
                    <th class="px-5 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($places as $place)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4">
                            <div>
                                <p class="font-medium text-slate-700">{{ $place->place_name }}</p>
                                <p class="text-xs text-slate-400 capitalize">{{ $place->category }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-500 hidden md:table-cell">{{ $place->city }}</td>
                        <td class="px-5 py-4 text-slate-500 hidden lg:table-cell">
                            {{ $place->partner?->business_name ?? '—' }}
                        </td>
                        <td class="px-5 py-4">
                            @switch($place->status)
                                @case('active')
                                    <span class="badge-active">Aktif</span>
                                    @break
                                @case('pending_review')
                                    <span class="badge-pending">Menunggu</span>
                                    @break
                                @case('inactive')
                                    <span class="badge-inactive">Nonaktif</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-5 py-4 hidden md:table-cell">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-slate-100 rounded-full h-1.5">
                                    <div class="bg-brand-400 h-1.5 rounded-full"
                                         style="width: {{ $place->data_completeness_score }}%"></div>
                                </div>
                                <span class="text-xs text-slate-500 w-8">{{ $place->data_completeness_score }}%</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2 justify-end">
                                <a href="{{ route('places.show', $place->place_id) }}"
                                   target="_blank"
                                   class="btn-ghost text-xs px-3 py-1.5">Lihat</a>

                                @if($place->status !== 'active')
                                    <button wire:click="approve({{ $place->place_id }})"
                                            wire:loading.attr="disabled"
                                            class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold transition-colors">
                                        Setujui
                                    </button>
                                @endif

                                @if($place->status !== 'inactive')
                                    <button wire:click="reject({{ $place->place_id }})"
                                            wire:loading.attr="disabled"
                                            class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-500 rounded-lg text-xs font-semibold transition-colors">
                                        Tolak
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                            Tidak ada tempat yang sesuai filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $places->links() }}
    </div>
</div>
