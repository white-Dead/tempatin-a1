<div>
    <div class="flex gap-2 mb-6">
        @foreach(['pending' => 'Menunggu', 'approved' => 'Disetujui', 'all' => 'Semua'] as $val => $label)
            <button wire:click="$set('filter', '{{ $val }}')"
                    class="{{ $filter === $val
                        ? 'px-4 py-2 bg-brand-500 text-white rounded-xl text-sm font-semibold'
                        : 'px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="space-y-3">
        @forelse($reviews as $review)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-semibold text-slate-700 text-sm">{{ $review->user?->full_name ?? 'Anonim' }}</span>
                        <span class="text-slate-400 text-xs">→</span>
                        <span class="text-slate-600 text-sm font-medium">{{ $review->place?->place_name ?? '—' }}</span>
                        <div class="flex text-amber-400 text-xs ml-auto">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating_overall ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="text-sm text-slate-500">{{ $review->comment }}</p>
                    @else
                        <p class="text-xs text-slate-400 italic">Tidak ada komentar</p>
                    @endif
                    <p class="text-xs text-slate-400 mt-2">{{ $review->created_at->format('d M Y H:i') }}</p>
                </div>
                @if(!$review->is_verified)
                    <div class="flex gap-2 flex-shrink-0 items-start">
                        <button wire:click="approve({{ $review->review_id }})"
                                class="px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl text-sm font-semibold transition-colors">
                            Setujui
                        </button>
                        <button wire:click="reject({{ $review->review_id }})"
                                wire:confirm="Hapus ulasan ini permanen?"
                                class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-500 rounded-xl text-sm font-semibold transition-colors">
                            Hapus
                        </button>
                    </div>
                @else
                    <span class="badge-active self-start">Disetujui</span>
                @endif
            </div>
        @empty
            <div class="text-center py-12 text-slate-400">
                Tidak ada ulasan yang perlu dimoderasi.
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $reviews->links() }}</div>
</div>
