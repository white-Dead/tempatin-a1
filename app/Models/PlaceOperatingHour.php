<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceOperatingHour extends Model
{
    protected $primaryKey = 'operating_hour_id';

    protected $fillable = [
        'place_id',
        'day_of_week',
        'opens_at',
        'closes_at',
        'is_closed',
    ];

    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'is_closed' => 'boolean',
        ];
    }

    public const DAY_LABELS = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'place_id');
    }

    public function dayLabel(): string
    {
        return self::DAY_LABELS[$this->day_of_week] ?? 'Hari';
    }

    public function timeRange(): string
    {
        if ($this->is_closed) {
            return 'Tutup';
        }

        if (! $this->opens_at || ! $this->closes_at) {
            return 'Belum tersedia';
        }

        return substr($this->opens_at, 0, 5).' - '.substr($this->closes_at, 0, 5);
    }
}
