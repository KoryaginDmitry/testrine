<?php

declare(strict_types=1);

namespace DkDev\Testrine\Resolvers\Contract;

use DkDev\Testrine\Support\Infrastructure\Reflection;

class ResponseContractResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return (bool) Reflection::make($this->route)->getJsonResourceClass();
    }
}
