<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use App\Models\User;
use DkDev\Testrine\Enums\RequestPayload\RulePriority;

class CurrentPasswordRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::TOP;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('current_password');
    }

    public function getValue(): string
    {
        if (! method_exists(User::class, 'factory')) {
            return '';
        }

        $definition = User::factory()->definition() ?? [];

        return $definition['password'] ?? '';
    }

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}
