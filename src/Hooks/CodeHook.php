<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\CodeContract;
use Dkdev\Testrine\Resolvers\Code\ValidDataCodeResolver;
use Dkdev\Testrine\Support\Infrastructure\Route;

class CodeHook extends BaseHook
{
    public function run(): int
    {
        if ($this->implements(contract: CodeContract::class)) {
            $codes = call_user_func([$this->test, 'codes']);

            return $codes[$this->getUserKey()];
        }

        return ValidDataCodeResolver::make(
            route: Route::getRouteByName($this->getRouteName()),
            group: $this->getGroupName(),
            userKey: $this->getUserKey()
        )
            ->handle();
    }
}
