<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Contract;

use Illuminate\Routing\Route;

class InvalidateCodeStrategy extends BaseContractStrategy
{
    public function needUse(Route $route): bool
    {
        return false;
    }
}
