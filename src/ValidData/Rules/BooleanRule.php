<?php

declare(strict_types=1);

namespace Dkdev\Testrine\ValidData\Rules;

use Dkdev\Testrine\Enums\ValidData\RulePriority;

class BooleanRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return in_array('boolean', $this->rules, true)
            || in_array('bool', $this->rules, true);
    }

    public function getValue(): string
    {
        return 'fake()->numberBetween(0,1)';
    }
}
