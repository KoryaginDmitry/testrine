<?php

declare(strict_types=1);

namespace DkDev\Testrine\Resolvers\Contract;

use DkDev\Testrine\Traits\HasContractRoutes;

class FakeStorageResolver extends ContractResolver
{
    use HasContractRoutes;

    public function defaultHandler(): bool
    {
        return $this->hasRoute(route: $this->route);
    }
}
