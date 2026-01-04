<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

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
            ->contains(fn (mixed $rule) => $this->contains('regex', $rule));
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

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}
