<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use DkDev\Testrine\Enums\ValidData\RulePriority;

class ImageRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return in_array('image', $this->rules, true);
    }

    public function getValue(): string
    {
        return 'fake()->image';
    }
}
