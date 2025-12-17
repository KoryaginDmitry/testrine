<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\Contracts\NotificationContract;

class NotifyHook extends BaseHook
{
    public function run(): void
    {
        if ($this->implements(contract: NotificationContract::class)) {
            call_user_func([$this->test, 'notifications']);
        }
    }
}
