<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\InvalidateContract;

class InvalidateHook extends BaseHook
{
    public function run(): array
    {
        return $this->implements(contract: InvalidateContract::class)
            ? call_user_func([$this->test, 'invalidData'])
            : [];
    }
}
