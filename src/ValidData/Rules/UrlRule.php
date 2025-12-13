<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use DkDev\Testrine\Enums\ValidData\RulePriority;

class UrlRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::HIGH;
    }

    public function hasThisRule(): bool
    {
        return in_array('url', $this->rules, true);
    }

    public function getValue(): string
    {
        return 'fake()->url()';
    }
}
