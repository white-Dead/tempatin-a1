<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $primaryKey = 'place_id';

    protected $fillable = [
        'partner_id',
        'place_name',
        'category',
        'address',
        'city',
        'latitude',
        'longitude',
        'price_range',
        'opening_hours',
        'description',
        'noise_level',
        'status',
        'data_completeness_score',
        'cover_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'data_completeness_score' => 'integer',
        ];
    }

    // --- Relations ---

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'partner_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'place_facilities', 'place_id', 'facility_id', 'place_id', 'facility_id')
            ->withPivot('notes');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'place_id', 'place_id');
    }

    public function verifiedReviews()
    {
        return $this->hasMany(Review::class, 'place_id', 'place_id')->where('is_verified', true);
    }

    public function photos()
    {
        return $this->hasMany(PlacePhoto::class, 'place_id', 'place_id');
    }

    public function promos()
    {
        return $this->hasMany(Promo::class, 'place_id', 'place_id')
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'place_id', 'place_id');
    }

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('places.status', 'active');
    }

    public function scopeNearby($query, float $lat, float $lng, float $radiusKm = 10)
    {
        // Bounding box dulu agar MySQL bisa pakai index lat/lng
        $latRange = $radiusKm / 111.0;
        $lngRange = $radiusKm / (111.0 * cos(deg2rad($lat)));

        return $query
            ->whereBetween('latitude', [$lat - $latRange, $lat + $latRange])
            ->whereBetween('longitude', [$lng - $lngRange, $lng + $lngRange])
            ->selectRaw(
                'places.*,
                (6371 * acos(
                    cos(radians(?)) * cos(radians(latitude))
                    * cos(radians(longitude) - radians(?))
                    + sin(radians(?)) * sin(radians(latitude))
                )) AS distance_km',
                [$lat, $lng, $lat]
            )
            ->having('distance_km', '<=', $radiusKm)
            ->orderBy('distance_km');
    }

    public function scopeHasFacilities($query, array $facilityNames)
    {
        foreach ($facilityNames as $name) {
            $query->whereHas('facilities', fn ($q) => $q->where('facility_name', $name));
        }

        return $query;
    }

    // --- Computed helpers ---

    public function getAvgOverallAttribute(): ?float
    {
        return $this->verifiedReviews()->avg('rating_overall');
    }

    public function getAvgWifiAttribute(): ?float
    {
        return $this->verifiedReviews()->avg('rating_wifi');
    }

    public function getTotalReviewsAttribute(): int
    {
        return $this->verifiedReviews()->count();
    }

    public function hasFacility(string $name): bool
    {
        return $this->facilities->contains('facility_name', $name);
    }

    public function recalculateCompleteness(): void
    {
        $score = 0;
        if ($this->address) {
            $score += 20;
        }
        if ($this->opening_hours) {
            $score += 20;
        }
        if ($this->price_range) {
            $score += 15;
        }
        if ($this->description) {
            $score += 15;
        }
        if ($this->facilities->count() > 0) {
            $score += 20;
        }

        $photoCount = $this->photos()->count();
        $score += min(10, $photoCount * 5);

        $this->update(['data_completeness_score' => $score]);
    }
}
