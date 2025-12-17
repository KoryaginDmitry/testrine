<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\InvalidParametersContract;

class InvalidParametersHook extends BaseHook
{
    public function run(): array
    {
        return $this->implements(contract: InvalidParametersContract::class)
            ? call_user_func([$this->test, 'invalidParameters'])
            : [];
    }
}
