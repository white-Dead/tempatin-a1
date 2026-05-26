<?php

namespace App\Livewire\Partner;

use App\Models\PartnerPosIntegration as PartnerPosIntegrationModel;
use App\Services\PosIntegration\PosIntegrationFactory;
use Livewire\Component;

class PosIntegration extends Component
{
    public string $provider = 'moka';

    public string $apiKey = '';

    public string $outletId = '';

    public ?string $connectionStatus = null;

    public ?string $syncMessage = null;

    protected function rules(): array
    {
        return [
            'provider' => 'required|in:moka,pawoon',
            'apiKey' => 'required|string',
            'outletId' => 'required|string|max:255',
        ];
    }

    public function mount(): void
    {
        $integration = $this->integration();

        if (! $integration) {
            return;
        }

        $this->provider = $integration->provider;
        $this->apiKey = (string) $integration->api_key;
        $this->outletId = $integration->outlet_id ?? '';
    }

    public function saveConfiguration(): void
    {
        $this->storeIntegration();
        $this->connectionStatus = null;
        $this->syncMessage = null;

        session()->flash('success', 'Konfigurasi integrasi kasir berhasil disimpan.');
    }

    public function testConnection(): void
    {
        $integration = $this->storeIntegration();
        $service = app(PosIntegrationFactory::class)->make($integration->provider, $integration);

        $this->connectionStatus = $service->testConnection()
            ? 'Koneksi kasir berhasil.'
            : 'Koneksi kasir gagal. Periksa API key dan Outlet ID.';
    }

    public function syncNow(): void
    {
        $integration = $this->storeIntegration();
        $place = auth()->user()->partner->places()->orderBy('place_id')->first();

        if (! $place) {
            $this->syncMessage = 'Belum ada tempat terdaftar. Daftarkan tempat terlebih dahulu.';

            return;
        }

        $result = app(PosIntegrationFactory::class)->make($integration->provider, $integration)->syncToPlace($place);
        $this->syncMessage = $result->success
            ? "{$result->itemsSynced} item berhasil disync."
            : 'Sinkronisasi gagal. '.($result->errorMessage ?? 'Periksa konfigurasi kasir.');
    }

    public function render()
    {
        $integration = $this->integration()?->load([
            'syncLogs' => fn ($query) => $query->latest('synced_at')->limit(5),
        ]);

        return view('livewire.partner.pos-integration', [
            'integration' => $integration,
            'logs' => $integration?->syncLogs ?? collect(),
        ]);
    }

    private function storeIntegration(): PartnerPosIntegrationModel
    {
        $this->validate();

        return PartnerPosIntegrationModel::updateOrCreate(
            ['partner_id' => auth()->user()->partner->partner_id],
            [
                'provider' => $this->provider,
                'api_key' => $this->apiKey,
                'outlet_id' => $this->outletId,
                'is_active' => true,
            ]
        );
    }

    private function integration(): ?PartnerPosIntegrationModel
    {
        return auth()->user()->partner?->posIntegration;
    }
}
