<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\NotificationContract;
use Illuminate\Support\Facades\Notification;

class NotificationHook extends BaseHook
{
    public function run(): void
    {
        if ($this->implements(contract: NotificationContract::class)) {
            Notification::fake();
        }
    }
}
