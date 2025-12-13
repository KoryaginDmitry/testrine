<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\InvalidateCodeContract;
use DkDev\Testrine\Helpers\Route;
use DkDev\Testrine\Strategies\Code\InvalidDataCodeStrategy;

class InvalidDataCodeHook extends BaseHook
{
    public function run(): int
    {
        $code = CodeHook::make(test: $this->test)->run();

        if ($this->implements(contract: InvalidateCodeContract::class)) {
            $defCode = call_user_func([$this->test, 'invalidDataCode']);
        } else {
            $defCode = InvalidDataCodeStrategy::make()
                ->handle(
                    route: Route::getRouteByName($this->getRouteName()),
                    group: $this->getGroupName(),
                    userKey: $this->getUserKey(),
                );
        }

        return $code >= 200 && $code < 399 ? $defCode : $code;
    }
}
