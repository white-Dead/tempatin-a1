<?php

namespace App\Livewire;

use App\Models\Place;
use App\Services\RecommendationScorer;
use Livewire\Attributes\Url;
use Livewire\Component;

class PlaceSearch extends Component
{
    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public array $facilities = [];

    #[Url]
    public bool $hasWifi = false;

    #[Url]
    public bool $hasAc = false;

    #[Url]
    public string $city = '';

    #[Url]
    public string $priceMax = '';

    #[Url]
    public string $noiseLevel = '';

    #[Url]
    public bool $nearbyOnly = false;

    public float $userLat = -7.7956;
    public float $userLng = 110.3695;

    public function updatedSearch(): void
    {
        // reset page when search changes
    }

    public function setUserLocation(float $lat, float $lng): void
    {
        $this->userLat = $lat;
        $this->userLng = $lng;
    }

    public function resetFilters(): void
    {
        $this->search     = '';
        $this->facilities = [];
        $this->city       = '';
        $this->priceMax   = '';
        $this->noiseLevel = '';
        $this->nearbyOnly = false;
        $this->hasWifi    = false;
        $this->hasAc      = false;
    }

    public function render()
    {
        $scorer = app(RecommendationScorer::class);

        $query = Place::query()
            ->with(['facilities', 'promos'])
            ->active()
            ->when($this->search, fn($q) =>
                $q->where(fn($sub) =>
                    $sub->where('place_name', 'like', "%{$this->search}%")
                        ->orWhere('address', 'like', "%{$this->search}%")
                        ->orWhere('city', 'like', "%{$this->search}%")
                )
            )
            ->when($this->city, fn($q) => $q->where('city', $this->city))
            ->when($this->facilities, fn($q) => $q->hasFacilities($this->facilities))
            ->when($this->hasWifi, fn($q) => $q->whereHas('facilities', fn($qq) => $qq->where('facility_name', 'wifi')))
            ->when($this->hasAc, fn($q) => $q->whereHas('facilities', fn($qq) => $qq->where('facility_name', 'ac')))
            ->when($this->priceMax, fn($q) =>
                $q->whereRaw("CAST(SUBSTRING_INDEX(price_range, '-', 1) AS UNSIGNED) <= ?", [$this->priceMax])
            )
            ->when($this->noiseLevel, fn($q) => $q->where('noise_level', $this->noiseLevel))
            ->when($this->nearbyOnly, fn($q) => $q->nearby($this->userLat, $this->userLng, 3));

        $places = $query->get()->map(function (Place $place) use ($scorer) {
            $place->recommendation_score = $scorer->score($place, $this->userLat, $this->userLng);
            return $place;
        });

        // Sponsored placement di atas, sisanya sorted by score
        $sponsored = $places->filter(fn($p) => $p->promos->isNotEmpty())
                            ->sortByDesc('recommendation_score');
        $regular   = $places->filter(fn($p) => $p->promos->isEmpty())
                            ->sortByDesc('recommendation_score');

        $sorted = $sponsored->concat($regular)->values();

        $facilities = \App\Models\Facility::orderBy('label')->get();
        $cities     = \Illuminate\Support\Facades\Cache::remember('available_cities', 3600, fn() =>
            Place::active()->distinct()->orderBy('city')->pluck('city')
        );

        return view('livewire.place-search', [
            'places'     => $sorted,
            'facilities' => $facilities,
            'cities'     => $cities,
        ]);
    }
}
