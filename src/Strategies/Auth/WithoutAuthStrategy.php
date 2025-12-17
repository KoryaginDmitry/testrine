<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Strategies\Auth;

use Dkdev\Testrine\BaseTestrineCase;

class WithoutAuthStrategy extends BaseAuthStrategy
{
    public function defaultHandler(): BaseTestrineCase
    {
        return $this->test;
    }
}
