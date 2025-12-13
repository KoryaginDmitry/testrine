<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\CodeContract;
use DkDev\Testrine\Helpers\Route;
use DkDev\Testrine\Strategies\Code\ValidDataCodeStrategy;

class CodeHook extends BaseHook
{
    public function run(): int
    {
        if ($this->implements(contract: CodeContract::class)) {
            $codes = call_user_func([$this->test, 'codes']);

            return $codes[$this->getUserKey()];
        }

        return ValidDataCodeStrategy::make()
            ->handle(
                route: Route::getRouteByName($this->getRouteName()),
                group: $this->getGroupName(),
                userKey: $this->getUserKey()
            );
    }
}
