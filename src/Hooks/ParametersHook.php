<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\ParametersContract;

class ParametersHook extends BaseHook
{
    public function run(): array
    {
        return $this->implements(contract: ParametersContract::class)
            ? call_user_func([$this->test, 'parameters'])
            : [];
    }
}
