<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;

class ImageRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('image');
    }

    public function getValue(): string
    {
        return Builder::make('fake()')
            ->property('image')
            ->build();
    }

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}
