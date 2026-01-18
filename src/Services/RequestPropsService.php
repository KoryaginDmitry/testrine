<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

class RequestPropsService extends BaseService
{
    private const ALL_ROUTES = '*';

    /**
     * @var array<string, array<string, string>>
     */
    protected array $props = [];

    public function add(
        string $propName,
        ?string $routeName = null,
        int|string $value = 1
    ): self {
        $route = $routeName ?? self::ALL_ROUTES;

        $this->props[$route][$propName] = $value;

        return $this;
    }

    public function list(string $routeName): array
    {
        $allRoutesProps = $this->props[self::ALL_ROUTES] ?? [];
        $routeProps = $this->props[$routeName] ?? [];

        return array_replace($allRoutesProps, $routeProps);
    }
}