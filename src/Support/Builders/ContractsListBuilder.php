<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Support\Builders;

use Dkdev\Testrine\Resolvers\Contract\ContractResolver;
use Dkdev\Testrine\Support\Infrastructure\Config;
use Dkdev\Testrine\Support\Infrastructure\Route;

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
