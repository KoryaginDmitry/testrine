<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\JobContract;
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
