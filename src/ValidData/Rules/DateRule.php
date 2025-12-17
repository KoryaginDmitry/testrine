<?php

declare(strict_types=1);

namespace Dkdev\Testrine\ValidData\Rules;

use Dkdev\Testrine\Enums\ValidData\RulePriority;
use Dkdev\Testrine\ValidData\Traits\HasRange;

class DateRule extends BaseRule
{
    use HasRange;

    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return in_array('date', $this->rules, true);
    }

    public function getValue(): string
    {
        $max = $this->max ?: 'now';

        return "fake()->date('Y-m-d', $max)";
    }
}
