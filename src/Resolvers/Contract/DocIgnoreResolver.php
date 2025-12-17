<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

use Dkdev\Testrine\Traits\HasContractRoutes;

class DocIgnoreResolver extends ContractResolver
{
    use HasContractRoutes;

    public function defaultHandler(): bool
    {
        return in_array(needle: $this->route->getName(), haystack: static::$contractRoutes);
    }
}
