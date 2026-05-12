<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $primaryKey = 'facility_id';

    public $timestamps = false;

    protected $fillable = [
        'facility_name',
        'icon_name',
        'label',
    ];

    public function places()
    {
        return $this->belongsToMany(Place::class, 'place_facilities', 'facility_id', 'place_id', 'facility_id', 'place_id')
            ->withPivot('notes');
    }
}
