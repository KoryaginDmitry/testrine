<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Auth;

use App\Models\User;
use DkDev\Testrine\BaseTestrineCase;

class WebAuthStrategy extends BaseAuthStrategy
{
    public function authorize(BaseTestrineCase $test, ?User $user): BaseTestrineCase
    {
        return $test->actingAs(user: $user);
    }
}
