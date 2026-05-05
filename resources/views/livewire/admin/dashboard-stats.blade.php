<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Top Places 7 hari --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-semibold text-slate-700 mb-4">Tempat Paling Banyak Dilihat (7 hari)</h3>
        @forelse($topPlaces as $i => $log)
            <div class="flex items-center gap-3 py-2.5 border-b border-slate-50 last:border-0">
                <span class="w-6 h-6 rounded-full bg-brand-100 text-brand-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                    {{ $i + 1 }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-slate-700 text-sm truncate">
                        {{ $log->place?->place_name ?? '(Dihapus)' }}
                    </p>
                    <p class="text-xs text-slate-400">{{ $log->place?->city }}</p>
                </div>
                <span class="text-sm font-semibold text-brand-600">{{ number_format($log->total_views) }}x</span>
            </div>
        @empty
            <p class="text-slate-400 text-sm text-center py-6">Belum ada data views.</p>
        @endforelse
    </div>

    {{-- Review menunggu moderasi --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-semibold text-slate-700 mb-4">Ulasan Menunggu Moderasi</h3>
        @forelse($recentReviews as $review)
            <div class="py-2.5 border-b border-slate-50 last:border-0">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700 truncate">
                            {{ $review->user?->full_name ?? 'Anonim' }}
                            <span class="text-slate-400 font-normal">→ {{ $review->place?->place_name ?? '—' }}</span>
                        </p>
                        @if($review->comment)
                            <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $review->comment }}</p>
                        @endif
                    </div>
                    <div class="flex text-amber-400 text-xs flex-shrink-0">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating_overall ? '★' : '☆' }}
                        @endfor
                    </div>
                </div>
            </div>
        @empty
            <p class="text-slate-400 text-sm text-center py-6">Semua ulasan sudah dimoderasi. 🎉</p>
        @endforelse

        @if($recentReviews->count() > 0)
            <a href="{{ route('admin.reviews') }}" class="btn-secondary w-full justify-center mt-4 text-sm">
                Lihat Semua Ulasan
            </a>
        @endif
    </div>
</div>
