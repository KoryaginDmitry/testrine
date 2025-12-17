<?php

declare(strict_types=1);

namespace Dkdev\Testrine\ValidData\Rules;

use Dkdev\Testrine\Enums\ValidData\RulePriority;
use Dkdev\Testrine\ValidData\Traits\HasRange;

class IntegerRule extends BaseRule
{
    use HasRange;

    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return in_array('integer', $this->rules, true);
    }

    public function getValue(): string
    {
        return "fake()->numberBetween($this->min, $this->max)";
    }
}
