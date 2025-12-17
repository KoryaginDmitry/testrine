<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\JobContract;

class JobHook extends BaseHook
{
    public function run(): void
    {
        if ($this->implements(contract: JobContract::class)) {
            call_user_func([$this->test, 'jobs']);
        }
    }
}
