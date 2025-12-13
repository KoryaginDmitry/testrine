<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Contract;

use Illuminate\Routing\Route;

class InvalidParametersContractStrategy extends BaseContractStrategy
{
    public function needUse(Route $route): bool
    {
        return count($route->parameterNames()) > 0;
    }
}
