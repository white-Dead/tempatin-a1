<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlaceMenuItemPhoto extends Model
{
    protected $primaryKey = 'menu_item_photo_id';

    protected $fillable = [
        'menu_item_id',
        'photo_url',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function menuItem()
    {
        return $this->belongsTo(PlaceMenuItem::class, 'menu_item_id', 'menu_item_id');
    }

    public function src(): string
    {
        if (Str::startsWith($this->photo_url, ['http://', 'https://'])) {
            return $this->photo_url;
        }

        if (Str::startsWith($this->photo_url, '/')) {
            return url($this->photo_url);
        }

        return asset('storage/'.$this->photo_url);
    }
}
