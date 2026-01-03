<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

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
            return "'$this->key' => ".self::getDefaultValue().",\n\t\t\t";
        }

        $pass = '"'.str(Str::password())->replace(['$', '""'], '')->value().'"';

        return Builder::make('')
            ->raw(code: "'password' => $pass,\n\t\t\t'password_confirmation' => $pass,\n\t\t\t", escape: false)
            ->build();
    }
}
