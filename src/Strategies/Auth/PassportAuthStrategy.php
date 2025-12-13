<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Auth;

use App\Models\User;
use DkDev\Testrine\BaseTestrineCase;
use Laravel\Passport\Passport;

class PassportAuthStrategy extends BaseAuthStrategy
{
    public function authorize(BaseTestrineCase $test, ?User $user): BaseTestrineCase
    {
        Passport::actingAs(user: $user, abilities: ['*']);

        return $test;
    }
}
