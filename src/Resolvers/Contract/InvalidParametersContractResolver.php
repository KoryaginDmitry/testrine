<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

class InvalidParametersContractResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return count($this->route->parameterNames()) > 0;
    }
}
