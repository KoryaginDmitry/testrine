<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

use DkDev\Testrine\Traits\Makeable;

abstract class BaseService
{
    use Makeable;

    protected static ?self $instance = null;

    public static function instance(): static
    {
        return self::$instance ??= self::make();
    }
}
