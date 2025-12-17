<?php

declare(strict_types=1);

namespace DkDev\Testrine\Support\Builders;

use DkDev\Testrine\Resolvers\Contract\ContractResolver;
use DkDev\Testrine\Support\Infrastructure\Config;
use DkDev\Testrine\Support\Infrastructure\Route;

class ContractsListBuilder
{
    public static function make(string $group, string $routeName): array
    {
        $result = [];

        $strategies = Config::getGroupValue(group: $group, key: 'contracts');

        /** @var ContractResolver $strategy */
        foreach ($strategies as $contract => $strategy) {
            if ($strategy::make(route: Route::getRouteByName(routeName: $routeName))->handle()) {
                $result[] = $contract;
            }
        }

        return $result;
    }
}
