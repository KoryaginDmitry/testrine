<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\InvalidParametersCodeContract;
use DkDev\Testrine\Helpers\Route;
use DkDev\Testrine\Strategies\Code\InvalidRouteParamsStrategy;

class InvalidParametersCodeHook extends BaseHook
{
    public function run(): int
    {
        if ($this->implements(contract: InvalidParametersCodeContract::class)) {
            $codes = call_user_func([$this->test, 'codesForInvalidParameters']);

            return $codes[$this->getUserKey()];
        }

        return InvalidRouteParamsStrategy::make()
            ->handle(
                route: Route::getRouteByName($this->getRouteName()),
                group: $this->getGroupName(),
                userKey: $this->getUserKey(),
            );
    }
}
