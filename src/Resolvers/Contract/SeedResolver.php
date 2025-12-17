<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

use Dkdev\Testrine\Traits\HasContractRoutes;

class SeedResolver extends ContractResolver
{
    use HasContractRoutes;

    public function defaultHandler(): bool
    {
        return $this->hasRoute(route: $this->route);
    }
}
