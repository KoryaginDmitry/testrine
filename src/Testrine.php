<?php

declare(strict_types=1);

namespace Dkdev\Testrine;

use Dkdev\Testrine\Services\BindService;
use Dkdev\Testrine\Services\HandlerService;
use Dkdev\Testrine\Services\RuleService;

class Testrine
{
    protected static array $instances = [];

    protected static function getInstance(string $instance)
    {
        if (isset(self::$instances[$instance])) {
            return self::$instances[$instance];
        }

        self::$instances[$instance] = new $instance;

        return self::$instances[$instance];
    }

    public static function rules(): RuleService
    {
        return self::getInstance(RuleService::class);
    }

    public static function binds(): BindService
    {
        return self::getInstance(BindService::class);
    }

    public function handlers(): HandlerService
    {
        return self::getInstance(HandlerService::class);
    }
}
