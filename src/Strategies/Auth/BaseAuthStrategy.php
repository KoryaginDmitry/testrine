<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Strategies\Auth;

use App\Models\User;
use Dkdev\Testrine\BaseTestrineCase;
use Dkdev\Testrine\Traits\HasHandler;
use Dkdev\Testrine\Traits\Makeable;

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
