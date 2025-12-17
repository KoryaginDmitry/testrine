<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Auth;

use DkDev\Testrine\BaseTestrineCase;
use Laravel\Passport\Passport;

class PassportAuthStrategy extends BaseAuthStrategy
{
    public function defaultHandler(): BaseTestrineCase
    {
        Passport::actingAs(user: $this->user, abilities: ['*']);

        return $this->test;
    }
}
