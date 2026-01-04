<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;

class BooleanRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('boolean') || $this->inRules('bool');
    }

    public function getValue(): string
    {
        return Builder::make('fake()')
            ->method('numberBetween', 0, 1)
            ->build();
    }
}
