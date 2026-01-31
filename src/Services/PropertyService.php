<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

class PropertyService extends BaseService
{
    protected array $descriptions = [];

    public function addDescription(string $key, string $value, ?string $routeName = null): static
    {
        $this->descriptions[$routeName ?: '*'][$key] = $value;

        return $this;
    }

    public function getDescription(string $routeName, string $key)
    {
        return $this->descriptions[$routeName][$key] ?? $this->descriptions['*'][$key] ?? null;
    }
}