<?php

namespace App\Http\Controllers;

use App\Models\Place;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Place::with(['facilities', 'promos'])
            ->active()
            ->where('data_completeness_score', '>=', 60)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $cities = Place::active()->distinct()->orderBy('city')->pluck('city');

        return view('welcome', compact('featured', 'cities'));
    }
}
