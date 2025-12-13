<?php

declare(strict_types=1);

namespace DkDev\Testrine;

use Closure;
use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Helpers\GetClassName;
use DkDev\Testrine\Helpers\RouteParameter;
use DkDev\Testrine\Strategies\BaseStrategy;
use DkDev\Testrine\Strategies\Code\BaseCodeStrategy;
use DkDev\Testrine\Traits\HasContractRoutes;
use DkDev\Testrine\ValidData\Rules\BaseRule;

class Testrine
{
    public static function getClassName(Closure $callback): void
    {
        GetClassName::$handler = $callback;
    }

    /**
     * @param  class-string<BaseStrategy>  $strategy
     */
    public static function setStrategyHandler(string $strategy, Closure $handler): void
    {
        $strategy::setHandler(callback: $handler);
    }

    /**
     * @param  class-string<HasContractRoutes>  $contract
     */
    public static function setContractRoutes(string $contract, array $routes): void
    {
        $contract::setContractRoutes(routes: $routes);
    }

    public static function bindValidRouteParameter(?string $routeName, string $key, string|Builder $value): void
    {
        RouteParameter::bindValid(routeName: $routeName, key: $key, value: $value);
    }

    public static function bindInvalidRouteParameter(?string $routeName, string $key, string $value): void
    {
        RouteParameter::bindInvalid(routeName: $routeName, key: $key, value: $value);
    }

    public static function bindValidDataValue(string $routeName, string $key, int|string|Builder $value): void
    {
        BaseRule::setDefaultValue(routeName: $routeName, key: $key, value: $value);
    }

    public static function setDefaultCode(string $strategy, string $routeName, int $value): void
    {
        BaseCodeStrategy::setDefaultCode(strategy: $strategy, routeName: $routeName, code: $value);
    }
}
