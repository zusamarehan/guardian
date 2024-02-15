<?php

namespace RehanKanak\Guardian\Services;

use RehanKanak\Guardian\Models\Guardian;

class RespondService
{
    public ?Guardian $guardian;

    public function checkIfValidTokenAvailable(string $resourceId): RespondService
    {
        $this->guardian = Guardian::query()
            ->where('resource_uuid', $resourceId)
            ->where('is_valid', true)
            ->first();

        return $this;
    }

    public function setResponse(string $response): RespondService
    {
        $this->guardian->response = $response;

        return $this;
    }

    public function process(): RespondService
    {
        if ($this->guardian->right_option !== $this->guardian->response) {
            $this->guardian->is_success = false;
        } else {
            $this->guardian->is_success = true;
        }

        return $this;
    }

    public function invalidateToken()
    {
        $this->guardian->is_valid = false;
        $this->guardian->save();

        return $this;
    }
}
