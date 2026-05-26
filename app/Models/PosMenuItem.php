<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosMenuItem extends Model
{
    protected $fillable = [
        'menu_item_id',
        'pos_item_id',
        'pos_item_name',
        'pos_price',
        'pos_category',
        'pos_is_available',
        'fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'pos_price' => 'integer',
            'pos_is_available' => 'boolean',
            'fetched_at' => 'datetime',
        ];
    }

    public function placeMenuItem()
    {
        return $this->belongsTo(PlaceMenuItem::class, 'menu_item_id', 'menu_item_id');
    }
}
