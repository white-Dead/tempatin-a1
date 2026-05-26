<?php

namespace App\Services\PosIntegration;

use App\Models\Place;

class PawoonService extends PosIntegrationService
{
    public function fetchMenuItems(string $outletId): array
    {
        return [];
    }

    public function syncToPlace(Place $place): SyncResult
    {
        $this->integration?->syncLogs()->create([
            'sync_type' => 'manual',
            'status' => 'partial',
            'items_synced' => 0,
            'error_message' => 'Integrasi Pawoon belum tersedia. Konfigurasi sudah dapat disimpan.',
            'synced_at' => now(),
        ]);

        return new SyncResult(false, 0, 'Integrasi Pawoon belum tersedia untuk sinkronisasi.');
    }

    public function testConnection(): bool
    {
        return false;
    }
}
