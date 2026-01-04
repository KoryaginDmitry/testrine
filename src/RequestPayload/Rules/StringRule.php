<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\Enums\ValidData\RulePriority;
use DkDev\Testrine\RequestPayload\Traits\HasRange;

class StringRule extends BaseRule
{
    use HasRange;

    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('string');
    }

    public function getValue(): string
    {
        return "str(fake()->realTextBetween($this->min, $this->max))->replace([\"'\", ';', '  ', '\"'], '')->limit($this->max, '')";
    }
}
