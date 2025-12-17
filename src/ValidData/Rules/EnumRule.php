<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use DkDev\Testrine\Enums\ValidData\RulePriority;

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
            if (str_starts_with((string) $rule, 'in:')) {
                $this->in = str((string) $rule)->after(':')->explode(',')->toArray();

                return true;
            }
        }

        return false;
    }

    public function getValue(): string
    {
        return 'collect(['.implode(',', $this->in).'])->random()';
    }
}
