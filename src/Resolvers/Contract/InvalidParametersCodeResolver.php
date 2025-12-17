<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

class InvalidParametersCodeResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return false;
    }
}
