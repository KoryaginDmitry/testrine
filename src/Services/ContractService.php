<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

use DkDev\Testrine\Traits\HasContractRoutes;

class ContractService extends BaseService
{
    /**
     * @param  class-string<HasContractRoutes>  $contract
     */
    public function setContractRoutes(string $contract, array $routes): void
    {
        $contract::setContractRoutes(routes: $routes);
    }

    /**
     * @param  class-string<HasContractRoutes>  $contract
     */
    public function getContractRoutes(string $contract): array
    {
        return $contract::getContractRoutes();
    }
}
