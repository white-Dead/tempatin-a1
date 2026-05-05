<x-layouts.admin>
    <x-slot name="title">Dashboard Admin</x-slot>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @foreach([
            ['label' => 'Total Tempat',        'value' => $stats['total_places'],    'icon' => '🏪', 'color' => 'bg-brand-50 text-brand-600'],
            ['label' => 'Menunggu Review',      'value' => $stats['pending_places'],  'icon' => '⏳', 'color' => 'bg-amber-50 text-amber-600'],
            ['label' => 'Ulasan Pending',       'value' => $stats['pending_reviews'], 'icon' => '💬', 'color' => 'bg-sky-50 text-sky-600'],
            ['label' => 'Views Hari Ini',       'value' => $stats['views_today'],     'icon' => '👁️', 'color' => 'bg-emerald-50 text-emerald-600'],
        ] as $s)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 {{ $s['color'] }} rounded-xl flex items-center justify-center text-lg">
                        {{ $s['icon'] }}
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-700">{{ number_format($s['value']) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Aksi Cepat --}}
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.places.index') }}" wire:navigate class="btn-primary">
            Moderasi Tempat ({{ $stats['pending_places'] }} pending)
        </a>
        <a href="{{ route('admin.reviews') }}" wire:navigate class="btn-secondary">
            Moderasi Ulasan ({{ $stats['pending_reviews'] }} pending)
        </a>
    </div>

    {{-- Stats Component --}}
    <livewire:admin.dashboard-stats />
</x-layouts.admin>
