<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Auth;

use App\Models\User;
use DkDev\Testrine\BaseTestrineCase;
use DkDev\Testrine\Strategies\BaseStrategy;

abstract class BaseAuthStrategy extends BaseStrategy
{
    public function handle(BaseTestrineCase $test, ?User $user): BaseTestrineCase
    {
        if (! empty(static::$handle)) {
            $callable = static::$handle;

            return $callable($test, $user);
        }

        return $this->authorize(test: $test, user: $user);
    }

    abstract public function authorize(BaseTestrineCase $test, ?User $user): BaseTestrineCase;
}
