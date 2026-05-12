<?php

namespace App\Livewire\Partner;

use App\Models\ActivityLog;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $partner = auth()->user()->partner;
        $places = $partner->places()->with(['facilities', 'promos'])->get();

        $stats = $places->map(function ($place) {
            return [
                'place' => $place,
                'views_7d' => ActivityLog::where('place_id', $place->place_id)
                    ->where('action_type', 'view_profile')
                    ->whereDate('created_at', '>=', now()->subDays(7))
                    ->count(),
                'routes_7d' => ActivityLog::where('place_id', $place->place_id)
                    ->where('action_type', 'click_route')
                    ->whereDate('created_at', '>=', now()->subDays(7))
                    ->count(),
            ];
        });

        return view('livewire.partner.dashboard', compact('partner', 'stats'));
    }
}
