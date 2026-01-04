<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;
use DkDev\Testrine\RequestPayload\Traits\HasRange;

class DateRule extends BaseRule
{
    use HasRange;

    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('date');
    }

    public function getValue(): string
    {
        $max = $this->max ?: 'now';

        return Builder::make('fake()')
            ->method('date', 'Y-m-d', $max)
            ->build();
    }
}
