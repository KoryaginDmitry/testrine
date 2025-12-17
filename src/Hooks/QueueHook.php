<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\JobContract;
use Illuminate\Support\Facades\Queue;

class QueueHook extends BaseHook
{
    public function run(): void
    {
        if ($this->implements(contract: JobContract::class)) {
            Queue::fake();
        }
    }
}
