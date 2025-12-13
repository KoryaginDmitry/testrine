<?php

declare(strict_types=1);

namespace DkDev\Testrine\Helpers;

use DkDev\Testrine\Strategies\Contract\BaseContractStrategy;

class GetContractsByRoute
{
    public static function make(string $group, string $routeName): array
    {
        $result = [];

        $strategies = Config::getGroupValue(group: $group, key: 'strategies.contracts');

        /** @var BaseContractStrategy $strategy */
        foreach ($strategies as $contract => $strategy) {
            if ($strategy::make()->handle(route: Route::getRouteByName(routeName: $routeName))) {
                $result[] = $contract;
            }
        }

        return $result;
    }
}
