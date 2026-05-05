<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $primaryKey = 'favorite_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'place_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'place_id');
    }
}
