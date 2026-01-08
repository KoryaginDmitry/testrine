<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\RequestPayload\RulePriority;
use Illuminate\Validation\Rules\Email;

class EmailRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('email') || $this->hasInstance(Email::class);
    }

    public function getValue(): string
    {
        return Builder::make('fake()')
            ->method('email')
            ->build();
    }

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}
