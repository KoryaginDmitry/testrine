<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\ResponseContract;
use Illuminate\Testing\TestResponse;

class ResponseHook extends BaseHook
{
    public function run(): void
    {
        /** @var TestResponse $response */
        $response = $this->args->get('response');

        if ($this->implements(contract: ResponseContract::class) && ($response->status() >= 200 && $response->status() < 300)) {
            $response->assertJsonStructure(
                call_user_func([$this->test, 'getResponseStructure'])
            );
        }
    }
}
