<?php

declare(strict_types=1);

namespace DkDev\Testrine\Handlers;

use DkDev\Testrine\Traits\HasHandler;
use DkDev\Testrine\Traits\Makeable;

abstract class Handler
{
    use HasHandler;
    use Makeable;
}
