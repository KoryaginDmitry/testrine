<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Services;

class RuleService extends BaseService
{
    public array $rules = [];

    public function add(string $rule)
    {
        $this->rules[] = $rule;
    }

    public function set(array $rules): void
    {
        $this->rules = $rules;
    }

    public function list(): array
    {
        return $this->rules;
    }

    public function clear(): void
    {
        $this->rules = [];
    }
}
