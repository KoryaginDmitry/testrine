<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Traits;

use Illuminate\Routing\Route;

trait HasContractRoutes
{
    public static array $contractRoutes = [];

    public static function setContractRoutes(array $routes): void
    {
        self::$contractRoutes = $routes;
    }

    public function hasRoute(Route $route): bool
    {
        return in_array(needle: $route->getName(), haystack: static::$contractRoutes);
    }
}
