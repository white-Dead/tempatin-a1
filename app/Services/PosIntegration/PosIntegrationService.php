<?php

namespace App\Services\PosIntegration;

use App\Models\PartnerPosIntegration;
use App\Models\Place;

abstract class PosIntegrationService
{
    public function __construct(
        protected ?PartnerPosIntegration $integration = null,
    ) {}

    abstract public function fetchMenuItems(string $outletId): array;

    abstract public function syncToPlace(Place $place): SyncResult;

    abstract public function testConnection(): bool;
}
