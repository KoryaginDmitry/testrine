<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\ValidateContract;

class ValidateHook extends BaseHook
{
    public function run(): mixed
    {
        return $this->implements(contract: ValidateContract::class)
            ? call_user_func([$this->test, 'validData'])
            : [];
    }
}
