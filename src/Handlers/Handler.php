<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Handlers;

use Dkdev\Testrine\Traits\HasHandler;
use Dkdev\Testrine\Traits\Makeable;

abstract class Handler
{
    use HasHandler;
    use Makeable;
}
