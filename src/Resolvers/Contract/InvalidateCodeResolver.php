<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

class InvalidateCodeResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return false;
    }
}
