<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\InvalidateContract;

class InvalidateHook extends BaseHook
{
    public function run(): array
    {
        return $this->implements(contract: InvalidateContract::class)
            ? call_user_func([$this->test, 'invalidData'])
            : [];
    }
}
