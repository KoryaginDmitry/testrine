<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Services;

use Dkdev\Testrine\Traits\Makeable;

abstract class BaseService
{
    use Makeable;

    protected static ?self $instance = null;

    public static function instance(): static
    {
        return self::$instance ??= self::make();
    }
}
