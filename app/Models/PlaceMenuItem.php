<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlaceMenuItem extends Model
{
    protected $primaryKey = 'menu_item_id';

    protected $fillable = [
        'place_id',
        'menu_name',
        'category',
        'price',
        'photo_url',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'place_id');
    }

    public function photos()
    {
        return $this->hasMany(PlaceMenuItemPhoto::class, 'menu_item_id', 'menu_item_id')
            ->orderBy('sort_order');
    }

    public function photoSrc(): ?string
    {
        if (! $this->photo_url) {
            return null;
        }

        if (Str::startsWith($this->photo_url, ['http://', 'https://'])) {
            return $this->photo_url;
        }

        if (Str::startsWith($this->photo_url, '/')) {
            return url($this->photo_url);
        }

        return asset('storage/'.$this->photo_url);
    }
}
