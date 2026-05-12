<?php

namespace App\Livewire\Admin;

use App\Models\Place;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PlaceModeration extends Component
{
    use WithPagination;

    #[Url]
    public string $statusFilter = 'pending_review';

    #[Url]
    public string $search = '';

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function approve(int $placeId): void
    {
        $place = Place::with('facilities', 'photos')->findOrFail($placeId);
        $place->update(['status' => 'active']);
        $place->recalculateCompleteness();
        session()->flash('success', "Tempat \"{$place->place_name}\" disetujui.");
    }

    public function reject(int $placeId): void
    {
        $place = Place::findOrFail($placeId);
        $place->update(['status' => 'inactive']);
        session()->flash('info', "Tempat \"{$place->place_name}\" ditolak.");
    }

    public function render()
    {
        $places = Place::with(['partner.user', 'facilities'])
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->search, fn ($q) => $q->where('place_name', 'like', "%{$this->search}%")
                ->orWhere('city', 'like', "%{$this->search}%")
            )
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.place-moderation', compact('places'));
    }
}
