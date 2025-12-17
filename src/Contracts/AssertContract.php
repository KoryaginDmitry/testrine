<?php

declare(strict_types=1);

namespace DkDev\Testrine\Contracts;

use Illuminate\Testing\TestResponse;

interface AssertContract
{
    public function assert(TestResponse $test, string $userKey): void;
}
