<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Code;

use Dkdev\Testrine\Strategies\Auth\WithoutAuthStrategy;
use Dkdev\Testrine\Support\Infrastructure\Config;
use Dkdev\Testrine\Traits\HasHandler;
use Dkdev\Testrine\Traits\Makeable;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method static CodeResolver make(Route $route, string $group, string $userKey)
 */
abstract class CodeResolver
{
    use HasHandler;
    use Makeable;

    public function __construct(
        protected Route $route,
        protected string $group,
        protected string $userKey
    ) {}

    public static array $defaultCodes = [
        InvalidDataCodeResolver::class => [
            '*' => Response::HTTP_UNPROCESSABLE_ENTITY,
        ],
        InvalidRouteParamsResolver::class => [
            '*' => Response::HTTP_NOT_FOUND,
        ],
        ValidDataCodeResolver::class => [
            '*' => Response::HTTP_OK,
        ],
    ];

    public static function setDefaultCode(string $resolver, string $routeName, int $code): void
    {
        self::$defaultCodes[$resolver][$routeName] = $code;
    }

    protected function isGuest(string $group, string $userKey): bool
    {
        return Config::getGroupValue(group: $group, key: "auth.$userKey") === WithoutAuthStrategy::class;
    }

    protected function getDefaultValue(Route $route)
    {
        return self::$defaultCodes[static::class][$route->getName()]
            ?? self::$defaultCodes[static::class]['*'];
    }
}
