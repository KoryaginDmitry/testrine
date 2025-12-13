<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Auth;

use App\Models\User;
use DkDev\Testrine\BaseTestrineCase;
use Laravel\Sanctum\Sanctum;

class SanctumAuthStrategy extends BaseAuthStrategy
{
    public function authorize(BaseTestrineCase $test, ?User $user): BaseTestrineCase
    {
        Sanctum::actingAs(user: $user);

        return $test;
    }
}
