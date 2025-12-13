<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Code;

use DkDev\Testrine\Helpers\Config;
use DkDev\Testrine\Strategies\Auth\WithoutAuthStrategy;
use DkDev\Testrine\Strategies\BaseStrategy;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseCodeStrategy extends BaseStrategy
{
    public static array $defaultCodes = [
        InvalidDataCodeStrategy::class => [
            '*' => Response::HTTP_UNPROCESSABLE_ENTITY,
        ],
        InvalidRouteParamsStrategy::class => [
            '*' => Response::HTTP_NOT_FOUND,
        ],
        ValidDataCodeStrategy::class => [
            '*' => Response::HTTP_OK,
        ],
    ];

    public static function setDefaultCode(string $strategy, string $routeName, int $code): void
    {
        self::$defaultCodes[$strategy][$routeName] = $code;
    }

    public function handle(Route $route, string $group, string $userKey): int
    {
        if (! empty(static::$handle)) {
            $callable = static::$handle;

            return $callable($route, $userKey);
        }

        return $this->makeCode(route: $route, group: $group, userKey: $userKey);
    }

    abstract public function makeCode(Route $route, string $group, string $userKey): int;

    protected function isGuest(string $group, string $userKey): bool
    {
        return Config::getGroupValue(group: $group, key: "strategies.auth.$userKey") === WithoutAuthStrategy::class;
    }

    protected function getDefaultValue(Route $route)
    {
        return self::$defaultCodes[static::class][$route->getName()]
            ?? self::$defaultCodes[static::class]['*'];
    }
}
