<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosSyncLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'integration_id',
        'sync_type',
        'status',
        'items_synced',
        'error_message',
        'synced_at',
    ];

    protected function casts(): array
    {
        return [
            'items_synced' => 'integer',
            'synced_at' => 'datetime',
        ];
    }

    public function integration()
    {
        return $this->belongsTo(PartnerPosIntegration::class, 'integration_id');
    }
}
