<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Strategies\Auth;

use Dkdev\Testrine\BaseTestrineCase;
use Laravel\Sanctum\Sanctum;

class SanctumAuthStrategy extends BaseAuthStrategy
{
    public function defaultHandler(): BaseTestrineCase
    {
        Sanctum::actingAs(user: $this->user);

        return $this->test;
    }
}
