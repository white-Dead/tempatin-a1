<?php

namespace App\Services\PosIntegration;

class SyncResult
{
    public function __construct(
        public readonly bool $success,
        public readonly int $itemsSynced = 0,
        public readonly ?string $errorMessage = null,
    ) {}
}
