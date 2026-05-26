<?php

namespace App\Services\PosIntegration;

use App\Models\PartnerPosIntegration;
use InvalidArgumentException;

class PosIntegrationFactory
{
    public function make(string $provider, ?PartnerPosIntegration $integration = null): PosIntegrationService
    {
        return match ($provider) {
            'moka' => new MokaService($integration),
            'pawoon' => new PawoonService($integration),
            default => throw new InvalidArgumentException("Provider POS {$provider} tidak didukung."),
        };
    }
}
