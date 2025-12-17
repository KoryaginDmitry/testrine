<?php

declare(strict_types=1);

namespace DkDev\Testrine\Resolvers\Contract;

class InvalidParametersCodeResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return false;
    }
}
