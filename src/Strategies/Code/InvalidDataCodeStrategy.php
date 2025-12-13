<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Code;

use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class InvalidDataCodeStrategy extends BaseCodeStrategy
{
    public function makeCode(Route $route, string $group, string $userKey): int
    {
        return $this->isGuest(group: $group, userKey: $userKey)
            ? Response::HTTP_UNAUTHORIZED
            : static::getDefaultValue(route: $route);
    }
}
