<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerPosIntegration extends Model
{
    protected $fillable = [
        'partner_id',
        'provider',
        'api_key',
        'outlet_id',
        'webhook_secret',
        'is_active',
        'last_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'api_key' => 'encrypted',
            'webhook_secret' => 'encrypted',
            'is_active' => 'boolean',
            'last_synced_at' => 'datetime',
        ];
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'partner_id');
    }

    public function syncLogs()
    {
        return $this->hasMany(PosSyncLog::class, 'integration_id');
    }
}
