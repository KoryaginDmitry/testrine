<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\RequestPayload\Rules\BaseRule;

class RuleService extends BaseService
{
    public array $rules = [];

    public function add(string $rule): void
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

    public function setDefaultValue(string $routeName, string $key, int|string|Builder $value): void
    {
        BaseRule::setDefaultValue(
            routeName: $routeName,
            key: $key,
            value: $value
        );
    }
}
