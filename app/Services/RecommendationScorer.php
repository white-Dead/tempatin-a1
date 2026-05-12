<?php

namespace App\Services;

use App\Models\Place;

class RecommendationScorer
{
    private const KEY_FACILITIES = ['wifi', 'stop_kontak', 'ac', 'parkir'];

    private const MAX_DISTANCE_KM = 5.0;

    private const MAX_PRICE = 50000.0;

    public function score(Place $place, float $userLat, float $userLng): float
    {
        return round(
            ($this->scoreFacilities($place) * 0.35) +
            ($this->scoreRating($place) * 0.25) +
            ($this->scoreDistance($place, $userLat, $userLng) * 0.20) +
            ($this->scorePrice($place) * 0.15) +
            (($place->data_completeness_score ?? 0) * 0.05),
            2
        );
    }

    private function scoreFacilities(Place $place): float
    {
        $found = $place->facilities->pluck('facility_name')->toArray();
        $matches = count(array_intersect(self::KEY_FACILITIES, $found));

        return ($matches / count(self::KEY_FACILITIES)) * 100;
    }

    private function scoreRating(Place $place): float
    {
        $avg = $place->avg_overall ?? 0;

        return ($avg / 5.0) * 100;
    }

    private function scoreDistance(Place $place, float $lat, float $lng): float
    {
        $km = $place->distance_km ?? $this->haversine($lat, $lng, $place->latitude, $place->longitude);

        return max(0, (1 - ($km / self::MAX_DISTANCE_KM)) * 100);
    }

    private function scorePrice(Place $place): float
    {
        if (! $place->price_range) {
            return 50.0;
        }

        $parts = explode('-', $place->price_range);
        if (count($parts) < 2) {
            return 50.0;
        }

        $avg = ((int) $parts[0] + (int) $parts[1]) / 2;

        return max(0, (1 - ($avg / self::MAX_PRICE)) * 100);
    }

    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
