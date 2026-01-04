<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;
use Illuminate\Support\Str;

class PasswordRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return $this->key === 'password';
    }

    public function getValue(): string
    {
        return '';
    }

    public function makeResult(): string
    {
        if (self::hasDefaultValue()) {
            return self::getDefaultValue();
        }

        $pass = '"'.str(Str::password())->replace(['$', '""'], '')->value().'"';

        return Builder::make('')
            ->raw(code: "$pass,\n\t\t\t'password_confirmation' => $pass", escape: false)
            ->build();
    }

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}
