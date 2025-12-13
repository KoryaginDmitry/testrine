<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Contract;

use DkDev\Testrine\Helpers\Reflection;
use Illuminate\Routing\Route;
use ReflectionException;

class ResponseContractStrategy extends BaseContractStrategy
{
    /**
     * @throws ReflectionException
     */
    public function needUse(Route $route): bool
    {
        return (bool) Reflection::make($route)->getJsonResourceClass();
    }
}
