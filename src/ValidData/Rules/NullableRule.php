<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;

class NullableRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::TOP;
    }

    public function hasThisRule(): bool
    {
        return (! $this->inRules('required') && ! $this->inRules('sometimes')) || $this->inRules('nullable');
    }

    public function getValue(): string
    {
        return Builder::make('')
            ->raw('')
            ->build();
    }
}
