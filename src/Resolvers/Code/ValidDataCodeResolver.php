<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Code;

use Symfony\Component\HttpFoundation\Response;

class ValidDataCodeResolver extends CodeResolver
{
    public function defaultHandler(): mixed
    {
        $isGuest = $this->isGuest(group: $this->group, userKey: $this->userKey);
        $hasAuth = collect($this->route->middleware())
            ->contains(fn (string $middleware) => str($middleware)->contains('auth'));

        return $isGuest && $hasAuth ? Response::HTTP_UNAUTHORIZED : static::getDefaultValue(route: $this->route);
    }
}
