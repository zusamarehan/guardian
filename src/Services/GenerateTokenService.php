<?php

namespace RehanKanak\Guardian\Services;

use Exception;
use RehanKanak\Guardian\Models\Guardian;

class GenerateTokenService
{
    public string $type;

    public Guardian $guardian;

    public function inValidatePreviousTokens(string $resourceId): void
    {
        Guardian::query()
            ->where('resource_uuid', $resourceId)
            ->update(['is_valid' => false]);
    }

    public function pickType(): GenerateTokenService
    {
        try {
            $randomNumber = random_int(1, 3);
            if ($randomNumber === 1) {
                $this->type = 'INPUT_NUMBER';
            } elseif ($randomNumber === 2) {
                $this->type = 'PRESS_NUMBER';
            } else {
                $this->type = 'APPROVE_DENY';
            }
        } catch (Exception) {
            $this->pickType();
        }

        return $this;
    }

    public function generate(): GenerateTokenService
    {
        $this->guardian->type = $this->type;

        match ($this->type) {
            'INPUT_NUMBER', 'PRESS_NUMBER' => $this->generateInputNumbers(),
            'APPROVE_DENY' => $this->generateApproveDeny(),
        };

        $this->guardian->save();

        return $this;
    }

    private function generateInputNumbers(): void
    {
        try {
            $this->guardian->options = [random_int(1, 100), random_int(1, 100), random_int(1, 100)];
            $this->guardian->right_option = (string) $this->guardian->options[array_rand($this->guardian->options, 1)];
        } catch (Exception) {
            $this->generateInputNumbers();
        }
    }

    private function generateApproveDeny(): void
    {
        $this->guardian->options = ['APPROVE', 'DENY'];
        $this->guardian->right_option = 'APPROVE';
    }

    public function setResource($resourceId): GenerateTokenService
    {
        $this->guardian->resource_uuid = $resourceId;

        return $this;
    }

    public function initiate(): GenerateTokenService
    {
        $this->guardian = new Guardian();

        return $this;
    }
}
