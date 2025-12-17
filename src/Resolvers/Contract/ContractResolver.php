<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

use Dkdev\Testrine\Traits\HasHandler;
use Dkdev\Testrine\Traits\Makeable;
use Illuminate\Routing\Route;

/**
 * @method static ContractResolver make(Route $route)
 */
abstract class ContractResolver
{
    use HasHandler;
    use Makeable;

    public function __construct(protected Route $route) {}
}
