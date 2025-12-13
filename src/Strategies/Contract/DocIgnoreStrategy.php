<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Contract;

use DkDev\Testrine\Traits\HasContractRoutes;
use Illuminate\Routing\Route;

class DocIgnoreStrategy extends BaseContractStrategy
{
    use HasContractRoutes;

    public function needUse(Route $route): bool
    {
        return in_array(needle: $route->getName(), haystack: static::$contractRoutes);
    }
}
