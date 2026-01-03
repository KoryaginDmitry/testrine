<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;

class RegexRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::TOP;
    }

    public function hasThisRule(): bool
    {
        return collect($this->rules)
            ->contains(fn (string $rule) => str($rule)->contains('regex'));
    }

    public function getValue(): string
    {
        $regexRule = collect($this->rules)
            ->first(fn (string $rule) => str($rule)->startsWith('regex:'));

        if (! is_string($regexRule)) {
            return "''";
        }

        $pattern = substr($regexRule, strlen('regex:'));

        return Builder::make('fake()')
            ->method('regexify', addslashes(trim($pattern, '/')))
            ->build();
    }
}
