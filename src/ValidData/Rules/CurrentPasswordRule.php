<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use App\Models\User;
use DkDev\Testrine\Enums\ValidData\RulePriority;

class CurrentPasswordRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::TOP;
    }

    public function hasThisRule(): bool
    {
        return in_array('current_password', $this->rules);
    }

    public function getValue(): string
    {
        if (! method_exists(User::class, 'factory')) {
            return '';
        }

        $definition = User::factory()->definition() ?? [];

        return $definition['password'] ?? '';
    }
}
