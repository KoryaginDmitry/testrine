<?php

declare(strict_types=1);

namespace Dkdev\Testrine\ValidData\Rules;

use Dkdev\Testrine\Enums\ValidData\RulePriority;

class EmailRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return in_array('email', $this->rules, true);
    }

    public function getValue(): string
    {
        return 'fake()->email()';
    }
}
