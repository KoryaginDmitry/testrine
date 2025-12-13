<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Contract;

use DkDev\Testrine\Strategies\BaseStrategy;
use Illuminate\Routing\Route;

abstract class BaseContractStrategy extends BaseStrategy
{
    public function handle(Route $route): bool
    {
        if (! empty(static::$handle)) {
            $callable = static::$handle;

            return $callable($route);
        }

        return $this->needUse(route: $route);
    }

    abstract public function needUse(Route $route): bool;
}
