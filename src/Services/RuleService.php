<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\RequestPayload\Rules\BaseRule;

class RuleService extends BaseService
{
    public array $rules = [];

    public function add(string $rule): self
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function set(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function list(): array
    {
        return $this->rules;
    }

    public function clear(): self
    {
        $this->rules = [];

        return $this;
    }

    public function setDefaultValue(string $routeName, string $key, int|string|Builder $value): self
    {
        BaseRule::setDefaultValue(
            routeName: $routeName,
            key: $key,
            value: $value
        );

        return $this;
    }
}
