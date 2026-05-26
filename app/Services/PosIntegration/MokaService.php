<?php

namespace App\Services\PosIntegration;

use App\Models\Place;
use App\Models\PlaceMenuItem;
use App\Models\PosMenuItem;
use Illuminate\Support\Facades\Http;
use Throwable;

class MokaService extends PosIntegrationService
{
    protected string $apiKey = '';

    public function fetchMenuItems(string $outletId): array
    {
        try {
            $response = $this->client()->get($this->baseUrl().'/menu-items');
            $items = $response->throw()->json('data', $response->json());

            return collect($items)
                ->map(fn (array $item) => [
                    'pos_item_id' => (string) $item['id'],
                    'pos_item_name' => $item['name'],
                    'pos_price' => (int) $item['price'],
                    'pos_category' => $item['category'] ?? null,
                    'pos_is_available' => (bool) ($item['is_available'] ?? true),
                ])
                ->all();
        } catch (Throwable $exception) {
            report($exception);

            throw $exception;
        }
    }

    public function syncToPlace(Place $place): SyncResult
    {
        $synced = 0;

        try {
            $items = $this->fetchMenuItems((string) $this->integration?->outlet_id);

            foreach ($items as $item) {
                $menuItem = PlaceMenuItem::where('place_id', $place->place_id)
                    ->where('external_id', $item['pos_item_id'])
                    ->first();

                if ($menuItem) {
                    $menuItem->update([
                        'menu_name' => $item['pos_item_name'],
                        'category' => $item['pos_category'],
                        'price' => $item['pos_price'],
                        'is_available' => $item['pos_is_available'],
                        'last_synced_at' => now(),
                    ]);
                } else {
                    $menuItem = $place->menuItems()->create([
                        'menu_name' => $item['pos_item_name'],
                        'category' => $item['pos_category'],
                        'price' => $item['pos_price'],
                        'source' => 'moka',
                        'is_available' => $item['pos_is_available'],
                        'external_id' => $item['pos_item_id'],
                        'last_synced_at' => now(),
                    ]);
                }

                PosMenuItem::updateOrCreate(
                    ['menu_item_id' => $menuItem->menu_item_id],
                    [
                        'pos_item_id' => $item['pos_item_id'],
                        'pos_item_name' => $item['pos_item_name'],
                        'pos_price' => $item['pos_price'],
                        'pos_category' => $item['pos_category'],
                        'pos_is_available' => $item['pos_is_available'],
                        'fetched_at' => now(),
                    ]
                );

                $synced++;
            }

            $this->integration?->forceFill(['last_synced_at' => now()])->save();
            $this->log('manual', 'success', $synced);

            return new SyncResult(true, $synced);
        } catch (Throwable $exception) {
            report($exception);
            $this->log('manual', 'failed', $synced, $exception->getMessage());

            return new SyncResult(false, $synced, $exception->getMessage());
        }
    }

    public function testConnection(): bool
    {
        try {
            $response = $this->client()->get($this->baseUrl().'/connection/test');

            return $response->ok() && $response->json('status') === 'connected';
        } catch (Throwable) {
            return false;
        }
    }

    private function log(string $syncType, string $status, int $itemsSynced, ?string $errorMessage = null): void
    {
        $this->integration?->syncLogs()->create([
            'sync_type' => $syncType,
            'status' => $status,
            'items_synced' => $itemsSynced,
            'error_message' => $errorMessage,
            'synced_at' => now(),
        ]);
    }

    private function client()
    {
        $this->apiKey = (string) $this->integration?->api_key;

        return Http::withHeaders(['X-Api-Key' => $this->apiKey])
            ->timeout(10);
    }

    private function baseUrl(): string
    {
        return rtrim(config('services.moka.base_url', 'http://localhost:8001/api/v1'), '/');
    }
}
