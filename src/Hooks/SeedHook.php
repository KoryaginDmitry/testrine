<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\SeedContract;

class SeedHook extends BaseHook
{
    public function run(): void
    {
        if ($this->implements(contract: SeedContract::class)) {
            call_user_func([$this->test, 'dbSeed']);
        }
    }
}
