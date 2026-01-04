<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;
use DkDev\Testrine\RequestPayload\Traits\HasRange;

class IntegerRule extends BaseRule
{
    use HasRange;

    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('integer');
    }

    public function getValue(): string
    {
        return Builder::make('fake()')
            ->method('numberBetween', $this->min, $this->max)
            ->build();
    }
}
