<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Auth;

use App\Models\User;
use DkDev\Testrine\BaseTestrineCase;
use DkDev\Testrine\Traits\HasHandler;
use DkDev\Testrine\Traits\Makeable;

/**
 * @method static BaseAuthStrategy make(BaseTestrineCase $test, ?User $user)
 */
abstract class BaseAuthStrategy
{
    use HasHandler;
    use Makeable;

    public function __construct(
        protected BaseTestrineCase $test,
        protected ?User $user,
    ) {}
}
