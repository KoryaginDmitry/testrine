<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Code;

use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class ValidDataCodeStrategy extends BaseCodeStrategy
{
    public function makeCode(Route $route, string $group, string $userKey): int
    {
        $isGuest = $this->isGuest(group: $group, userKey: $userKey);
        $hasAuth = collect($route->middleware())
            ->contains(fn (string $middleware) => str($middleware)->contains('auth'));

        return $isGuest && $hasAuth ? Response::HTTP_UNAUTHORIZED : static::getDefaultValue(route: $route);
    }
}
