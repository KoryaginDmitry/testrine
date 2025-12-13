<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use DkDev\Testrine\Enums\ValidData\RulePriority;

class NullableRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::TOP;
    }

    public function hasThisRule(): bool
    {
        return (
            ! in_array('required', $this->rules, true)
            && ! in_array('sometimes', $this->rules, true)
        )
            || in_array('nullable', $this->rules, true);
    }

    public function getValue(): string
    {
        return "''";
    }
}
