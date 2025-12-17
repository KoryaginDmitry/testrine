<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\ValidateContract;

class ValidateHook extends BaseHook
{
    public function run(): mixed
    {
        return $this->implements(contract: ValidateContract::class)
            ? call_user_func([$this->test, 'validData'])
            : [];
    }
}
