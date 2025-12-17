<?php

declare(strict_types=1);

namespace DkDev\Testrine\Resolvers\Contract;

use DkDev\Testrine\Traits\HasHandler;
use DkDev\Testrine\Traits\Makeable;
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
