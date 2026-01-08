<?php

declare(strict_types=1);

namespace DkDev\Testrine\EventHandlers;

use DkDev\Testrine\Traits\HasHandler;
use DkDev\Testrine\Traits\Makeable;

abstract class EventHandler
{
    use HasHandler;
    use Makeable;
}
