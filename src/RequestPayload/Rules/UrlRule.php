<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;

class UrlRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::HIGH;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('url');
    }

    public function getValue(): string
    {
        return Builder::make('fake()')->method('url')->build();
    }

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}
