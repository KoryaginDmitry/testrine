<?php

declare(strict_types=1);

namespace DkDev\Testrine\Resolvers\Code;

use Symfony\Component\HttpFoundation\Response;

class InvalidDataCodeResolver extends CodeResolver
{
    public function defaultHandler(): mixed
    {
        return $this->isGuest(group: $this->group, userKey: $this->userKey)
            ? Response::HTTP_UNAUTHORIZED
            : static::getDefaultValue(route: $this->route);
    }
}
