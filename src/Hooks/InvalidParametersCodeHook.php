<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\InvalidParametersCodeContract;
use Dkdev\Testrine\Resolvers\Code\InvalidRouteParamsResolver;
use Dkdev\Testrine\Support\Infrastructure\Route;

class InvalidParametersCodeHook extends BaseHook
{
    public function run(): int
    {
        if ($this->implements(contract: InvalidParametersCodeContract::class)) {
            $codes = call_user_func([$this->test, 'codesForInvalidParameters']);

            return $codes[$this->getUserKey()];
        }

        return InvalidRouteParamsResolver::make(
            route: Route::getRouteByName($this->getRouteName()),
            group: $this->getGroupName(),
            userKey: $this->getUserKey(),
        )
            ->handle();
    }
}
