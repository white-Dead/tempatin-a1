<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'user_id',
        'place_id',
        'rating_wifi',
        'rating_comfort',
        'rating_socket',
        'rating_overall',
        'comment',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'is_verified'    => 'boolean',
            'rating_wifi'    => 'integer',
            'rating_comfort' => 'integer',
            'rating_socket'  => 'integer',
            'rating_overall' => 'integer',
        ];
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
