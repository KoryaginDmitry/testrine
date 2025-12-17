<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Support\Infrastructure;

use Dkdev\Testrine\CodeBuilder\Builder;

class RouteParameter
{
    // todo переезд в сервисы
    protected static array $validBinds = [
        '*' => 1,
    ];

    protected static array $invalidBinds = [
        '*' => 999999,
    ];

    public static function bindValid(?string $routeName, string $key, string|Builder $value): void
    {
        $value = $value instanceof Builder ? $value->build() : $value;

        if ($routeName) {
            self::$validBinds[$routeName][$key] = $value;
        } else {
            self::$validBinds[$key] = $value;
        }
    }

    public static function bindInvalid(?string $routeName, string $key, string $value): void
    {
        if ($routeName) {
            self::$invalidBinds[$routeName][$key] = $value;
        } else {
            self::$invalidBinds[$key] = $value;
        }
    }

    public static function makeValidValue(string $routeName, string $key): int|string
    {
        if (isset(self::$validBinds[$routeName][$key])) {
            return ''.self::$validBinds[$routeName][$key];
        }

        return isset(self::$validBinds[$key]) ? ''.self::$validBinds[$key] : ''.self::$validBinds['*'];
    }

    public static function makeInvalidValue(string $routeName, string $key): int|string
    {
        if (isset(self::$invalidBinds[$routeName][$key])) {
            return ''.self::$invalidBinds[$routeName][$key];
        }

        return isset(self::$invalidBinds[$key])
            ? ''.self::$invalidBinds[$key]
            : ''.self::$invalidBinds['*'];
    }
}
