<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;
use Illuminate\Validation\Rules\Enum;

class EnumRule extends BaseRule
{
    protected array $in = [];

    public function getPriority(): RulePriority
    {
        return RulePriority::HIGH;
    }

    public function hasThisRule(): bool
    {
        foreach ($this->rules as $rule) {
            if ($this->isInstance(Enum::class, $rule)) {
                // $rule->

                // todo
                return true;
            }

            if ($this->startsWith('in:', $rule)) {
                $this->in = str((string) $rule)->after(':')->explode(',')->toArray();

                return true;
            }
        }

        return false;
    }

    public function getValue(): string
    {
        return Builder::make('')
            ->func('collect', $this->in)
            ->method('random')
            ->build();
    }
}
