<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

class CodeContractResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return true;
    }
}
