<?php

declare(strict_types=1);

namespace DkDev\Testrine\Resolvers\Contract;

use DkDev\Testrine\Traits\HasContractRoutes;

class DocIgnoreResolver extends ContractResolver
{
    use HasContractRoutes;

    public function defaultHandler(): bool
    {
        return in_array(needle: $this->route->getName(), haystack: static::$contractRoutes);
    }
}
