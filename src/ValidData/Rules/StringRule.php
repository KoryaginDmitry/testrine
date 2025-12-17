<?php

declare(strict_types=1);

namespace Dkdev\Testrine\ValidData\Rules;

use Dkdev\Testrine\Enums\ValidData\RulePriority;
use Dkdev\Testrine\ValidData\Traits\HasRange;

class StringRule extends BaseRule
{
    use HasRange;

    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return in_array('string', $this->rules, true);
    }

    public function getValue(): string
    {
        return "str(fake()->realTextBetween($this->min, $this->max))->replace([\"'\", ';', '  ', '\"'], '')->limit($this->max, '')";
    }
}
