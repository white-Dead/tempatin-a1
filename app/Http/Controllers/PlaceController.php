<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index()
    {
        return view('places.index');
    }

    public function show(Place $place)
    {
        abort_if($place->status !== 'active', 404);

        $place->load(['facilities', 'verifiedReviews.user', 'promos', 'photos', 'menuItems.photos', 'operatingHours']);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'place_id' => $place->place_id,
            'action_type' => 'view_profile',
            'created_at' => now(),
        ]);

        $userHasReviewed = auth()->check()
            ? $place->reviews()->where('user_id', auth()->id())->exists()
            : false;

        return view('places.show', compact('place', 'userHasReviewed'));
    }

    public function logAction(Request $request, Place $place)
    {
        $request->validate([
            'action_type' => 'required|in:click_route,click_contact,click_promo',
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'place_id' => $place->place_id,
            'action_type' => $request->action_type,
            'created_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }

    public function favorites()
    {
        $places = auth()->user()->favoritePlaces()->with(['facilities'])->paginate(12);

        return view('places.favorites', compact('places'));
    }
}
