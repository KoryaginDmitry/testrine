<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use DkDev\Testrine\Helpers\Config;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

class AuthStrategy extends BaseParserStrategy
{
    public function getName(): string
    {
        return 'auth';
    }

    public function analyze(TestResponse $response, Collection $attributes): mixed
    {
        return in_array(Config::getSwaggerValue('auth.middleware'), $this->getRoute()?->middleware(), true);
    }
}
