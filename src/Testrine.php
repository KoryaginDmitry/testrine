<?php

declare(strict_types=1);

namespace DkDev\Testrine;

use DkDev\Testrine\Services\CodeService;
use DkDev\Testrine\Services\ContractService;
use DkDev\Testrine\Services\HandlerService;
use DkDev\Testrine\Services\RouteParamsService;
use DkDev\Testrine\Services\RuleService;

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

    public static function code(): CodeService
    {
        return self::getInstance(CodeService::class);
    }

    public static function contracts(): ContractService
    {
        return self::getInstance(CodeService::class);
    }

    public static function handlers(): HandlerService
    {
        return self::getInstance(HandlerService::class);
    }

    public static function routeParams(): RouteParamsService
    {
        return self::getInstance(RouteParamsService::class);
    }

    public static function rules(): RuleService
    {
        return self::getInstance(RuleService::class);
    }
}
