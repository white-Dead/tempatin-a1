<div class="max-w-4xl space-y-6">
    <div class="bg-white border border-slate-100 rounded-2xl shadow-card p-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-700">Integrasi Kasir</h2>
                <p class="text-sm text-slate-400 mt-1">Hubungkan menu kasir dengan menu tempat di Tempatin.</p>
            </div>
            <div>
                @if($integration?->is_active)
                    <span class="badge-active">Aktif</span>
                @else
                    <span class="badge-inactive">Belum Aktif</span>
                @endif
            </div>
        </div>

        <form wire:submit="saveConfiguration" class="mt-6 grid grid-cols-1 gap-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="input-label">Provider Kasir <span class="text-rose-400">*</span></label>
                    <select wire:model="provider" class="input">
                        <option value="moka">Moka POS</option>
                        <option value="pawoon">Pawoon</option>
                    </select>
                    @error('provider') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="input-label">Outlet ID <span class="text-rose-400">*</span></label>
                    <input type="text" wire:model="outletId" class="input" placeholder="Contoh: outlet-jogja-01">
                    @error('outletId') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="input-label">API Key <span class="text-rose-400">*</span></label>
                <input type="password" wire:model="apiKey" class="input" placeholder="Masukkan API key kasir">
                @error('apiKey') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-3 pt-1 sm:flex-row">
                <button type="submit" class="btn-primary justify-center">
                    <span wire:loading.remove wire:target="saveConfiguration">Simpan Konfigurasi</span>
                    <span wire:loading wire:target="saveConfiguration">Menyimpan...</span>
                </button>

                <button type="button" wire:click="testConnection" class="btn-secondary justify-center">
                    <span wire:loading.remove wire:target="testConnection">Test Koneksi</span>
                    <span wire:loading wire:target="testConnection">Mengecek...</span>
                </button>

                <button type="button" wire:click="syncNow" class="btn-secondary justify-center">
                    <span wire:loading.remove wire:target="syncNow">Sync Sekarang</span>
                    <span wire:loading wire:target="syncNow">Sinkronisasi...</span>
                </button>
            </div>
        </form>

        @if($connectionStatus)
            <div class="mt-5 rounded-xl border px-4 py-3 text-sm {{ str_contains($connectionStatus, 'berhasil') ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
                {{ $connectionStatus }}
            </div>
        @endif

        @if($syncMessage)
            <div class="mt-5 rounded-xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-700">
                {{ $syncMessage }}
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[1fr_2fr]">
        <div class="bg-white border border-slate-100 rounded-2xl shadow-card p-6">
            <p class="text-sm font-semibold text-slate-500">Sinkronisasi Terakhir</p>
            <p class="mt-2 text-lg font-semibold text-slate-700">
                {{ $integration?->last_synced_at?->format('d M Y H:i') ?? 'Belum pernah sync' }}
            </p>
            <p class="mt-2 text-sm text-slate-400">Menu dari kasir akan memperbarui harga, kategori, dan status ketersediaan.</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl shadow-card overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-700">Riwayat Sync</h3>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($logs as $log)
                    <div wire:key="pos-sync-log-{{ $log->id }}" class="grid grid-cols-1 gap-3 px-6 py-4 sm:grid-cols-[1fr_auto_auto] sm:items-center">
                        <div>
                            <p class="text-sm font-medium text-slate-700">{{ $log->synced_at->format('d M Y H:i') }}</p>
                            @if($log->error_message)
                                <p class="text-xs text-slate-400 mt-1">{{ $log->error_message }}</p>
                            @endif
                        </div>

                        <div>
                            @switch($log->status)
                                @case('success')
                                    <span class="badge-active">Berhasil</span>
                                    @break
                                @case('partial')
                                    <span class="badge-pending">Sebagian</span>
                                    @break
                                @default
                                    <span class="badge-inactive">Gagal</span>
                            @endswitch
                        </div>

                        <p class="text-sm text-slate-500">{{ $log->items_synced }} item</p>
                    </div>
                @empty
                    <div class="px-6 py-8 text-sm text-slate-400">
                        Belum ada riwayat sinkronisasi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
