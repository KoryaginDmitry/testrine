<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\RequestPayload\RulePriority;

class IpRule extends BaseRule
{

    public function getPriority(): RulePriority
    {
        return RulePriority::TOP;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('ip');
    }

    public function getValue(): string
    {
        return Builder::make('fake()')
            ->method('ipv4')
            ->build();
    }

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}