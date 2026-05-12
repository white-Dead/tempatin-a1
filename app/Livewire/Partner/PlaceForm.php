<?php

namespace App\Livewire\Partner;

use App\Models\Facility;
use App\Models\Place;
use App\Models\PlaceOperatingHour;
use Livewire\Component;
use Livewire\WithFileUploads;

class PlaceForm extends Component
{
    use WithFileUploads;

    public ?int $placeId = null;

    public string $placeName = '';

    public string $category = 'cafe';

    public string $address = '';

    public string $city = '';

    public string $latitude = '';

    public string $longitude = '';

    public string $priceRange = '';

    public string $openingHours = '';

    public array $operatingHours = [];

    public string $description = '';

    public string $noiseLevel = 'sedang';

    public array $selectedFacilities = [];

    public $photos = [];

    protected function rules(): array
    {
        return [
            'placeName' => 'required|string|max:150',
            'category' => 'required|in:cafe,coworking,restoran,perpustakaan,lainnya',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'priceRange' => 'nullable|string|max:50',
            'openingHours' => 'nullable|string|max:255',
            'operatingHours.*.opens_at' => 'nullable|date_format:H:i',
            'operatingHours.*.closes_at' => 'nullable|date_format:H:i',
            'operatingHours.*.is_closed' => 'boolean',
            'description' => 'nullable|string|max:2000',
            'noiseLevel' => 'required|in:tenang,sedang,ramai',
            'photos.*' => 'nullable|image|max:3072',
        ];
    }

    public function mount(?int $placeId = null): void
    {
        $this->setDefaultOperatingHours();

        if ($placeId) {
            $place = Place::with(['facilities', 'operatingHours'])->findOrFail($placeId);
            $this->placeId = $place->place_id;
            $this->placeName = $place->place_name;
            $this->category = $place->category;
            $this->address = $place->address;
            $this->city = $place->city;
            $this->latitude = (string) $place->latitude;
            $this->longitude = (string) $place->longitude;
            $this->priceRange = $place->price_range ?? '';
            $this->openingHours = $place->opening_hours ?? '';
            $this->description = $place->description ?? '';
            $this->noiseLevel = $place->noise_level;
            $this->selectedFacilities = $place->facilities->pluck('facility_id')->toArray();

            foreach ($place->operatingHours as $hours) {
                $this->operatingHours[$hours->day_of_week] = [
                    'opens_at' => $hours->opens_at ? substr($hours->opens_at, 0, 5) : '',
                    'closes_at' => $hours->closes_at ? substr($hours->closes_at, 0, 5) : '',
                    'is_closed' => $hours->is_closed,
                ];
            }
        }
    }

    public function save(): void
    {
        $this->validate();

        $partner = auth()->user()->partner;
        $this->openingHours = $this->summaryOpeningHours();

        $data = [
            'partner_id' => $partner->partner_id,
            'place_name' => $this->placeName,
            'category' => $this->category,
            'address' => $this->address,
            'city' => $this->city,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'price_range' => $this->priceRange,
            'opening_hours' => $this->openingHours,
            'description' => $this->description,
            'noise_level' => $this->noiseLevel,
            'status' => 'pending_review',
        ];

        $place = $this->placeId
            ? tap(Place::findOrFail($this->placeId))->update($data)
            : Place::create($data);

        $place->facilities()->sync($this->selectedFacilities);

        foreach ($this->operatingHours as $day => $hours) {
            $isClosed = (bool) ($hours['is_closed'] ?? false);

            $place->operatingHours()->updateOrCreate(
                ['day_of_week' => (int) $day],
                [
                    'opens_at' => $isClosed ? null : ($hours['opens_at'] ?: null),
                    'closes_at' => $isClosed ? null : ($hours['closes_at'] ?: null),
                    'is_closed' => $isClosed,
                ]
            );
        }

        // Upload foto
        foreach ($this->photos as $photo) {
            $path = $photo->store('places', 'public');
            $place->photos()->create(['photo_url' => $path, 'is_cover' => false]);
        }

        $place->recalculateCompleteness();

        $this->dispatch('place-saved');
        session()->flash('success', 'Tempat berhasil disimpan dan menunggu verifikasi admin.');

        $this->redirect(route('partner.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.partner.place-form', [
            'allFacilities' => Facility::orderBy('label')->get(),
            'dayLabels' => PlaceOperatingHour::DAY_LABELS,
        ]);
    }

    private function setDefaultOperatingHours(): void
    {
        foreach (PlaceOperatingHour::DAY_LABELS as $day => $label) {
            $this->operatingHours[$day] = [
                'opens_at' => '08:00',
                'closes_at' => '22:00',
                'is_closed' => false,
            ];
        }
    }

    private function summaryOpeningHours(): string
    {
        $firstOpenDay = collect($this->operatingHours)
            ->first(fn (array $hours) => ! ($hours['is_closed'] ?? false) && ($hours['opens_at'] ?? null) && ($hours['closes_at'] ?? null));

        if (! $firstOpenDay) {
            return '';
        }

        return $firstOpenDay['opens_at'].'-'.$firstOpenDay['closes_at'];
    }
}
