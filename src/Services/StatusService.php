<?php

namespace RehanKanak\Guardian\Services;

use RehanKanak\Guardian\Models\Guardian;

class StatusService
{
    public ?Guardian $guardian;

    public int $status;

    public function fetchLatestTokenByResource(string $resourceId): StatusService
    {
        $this->guardian = Guardian::query()
            ->where('resource_uuid', $resourceId)
            ->latest()
            ->first();

        return $this;
    }

    public function fetchStatus(): StatusService
    {
        if (! $this->guardian->is_valid) {
            $this->status = $this->guardian->is_success;
        } else {
            $this->status = -1;
        }

        return $this;
    }
}
