<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Auth;

use DkDev\Testrine\BaseTestrineCase;

class WebAuthStrategy extends BaseAuthStrategy
{
    public function defaultHandler(): BaseTestrineCase
    {
        return $this->test->actingAs(user: $this->user);
    }
}
