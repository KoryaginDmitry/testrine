<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\AssertContract;

class AssertHook extends BaseHook
{
    public function run(): void
    {
        if ($this->implements(contract: AssertContract::class)) {
            call_user_func([$this->test, 'assert'], $this->args->firstWhere('response'));
        }
    }
}
