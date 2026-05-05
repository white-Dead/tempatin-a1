<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacePhoto extends Model
{
    protected $primaryKey = 'photo_id';

    protected $fillable = [
        'place_id',
        'photo_url',
        'is_cover',
        'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_cover' => 'boolean'];
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'place_id');
    }
}
