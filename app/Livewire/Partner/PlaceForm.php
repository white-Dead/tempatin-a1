<?php

namespace App\Livewire\Partner;

use App\Models\Facility;
use App\Models\Place;
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
            'description' => 'nullable|string|max:2000',
            'noiseLevel' => 'required|in:tenang,sedang,ramai',
            'photos.*' => 'nullable|image|max:3072',
        ];
    }

    public function mount(?int $placeId = null): void
    {
        if ($placeId) {
            $place = Place::with('facilities')->findOrFail($placeId);
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
        }
    }

    public function save(): void
    {
        $this->validate();

        $partner = auth()->user()->partner;

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
        ]);
    }
}
