<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\InvalidateCodeContract;
use Dkdev\Testrine\Resolvers\Code\InvalidDataCodeResolver;
use Dkdev\Testrine\Support\Infrastructure\Route;

class InvalidDataCodeHook extends BaseHook
{
    public function run(): int
    {
        $code = CodeHook::make(test: $this->test)->run();

        if ($this->implements(contract: InvalidateCodeContract::class)) {
            $defCode = call_user_func([$this->test, 'invalidDataCode']);
        } else {
            $defCode = InvalidDataCodeResolver::make(
                route: Route::getRouteByName($this->getRouteName()),
                group: $this->getGroupName(),
                userKey: $this->getUserKey(),
            )->handle();
        }

        return $code >= 200 && $code < 399 ? $defCode : $code;
    }
}
