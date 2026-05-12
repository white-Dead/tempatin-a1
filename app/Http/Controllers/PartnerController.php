<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Promo;

class PartnerController extends Controller
{
    public function dashboard()
    {
        $partner = auth()->user()->partner;
        $places = $partner->places()->with(['facilities', 'promos'])->get();

        return view('partner.dashboard', compact('partner', 'places'));
    }

    public function createPlace()
    {
        return view('partner.places.create');
    }

    public function editPlace(Place $place)
    {
        abort_unless($place->partner_id === auth()->user()->partner->partner_id, 403);

        $place->load('facilities');

        return view('partner.places.edit', compact('place'));
    }

    public function promos()
    {
        $partner = auth()->user()->partner;
        $promos = Promo::whereIn('place_id', $partner->places->pluck('place_id'))
            ->with('place')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('partner.promos', compact('promos'));
    }
}
