<?php

namespace DkDev\Testrine\Support\Infrastructure;

use Illuminate\Support\Collection;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

class Route
{
    public static function getParametersByUrl(string $uri): Collection
    {
        $parameters = [];

        preg_match_all(pattern: '/\{\w+}/', subject: $uri, matches: $parameters);

        return collect($parameters[0] ?? []);
    }

    public static function getRouteByName(string $routeName): \Illuminate\Routing\Route
    {
        return \Illuminate\Support\Facades\Route::getRoutes()->getByName(name: $routeName);
    }

    /**
     * @throws ReflectionException
     */
    public static function hasInjection(\Illuminate\Routing\Route $route, string $injection): bool
    {
        $action = $route->getActionName();

        if (! str_contains($action, '@')) {
            return false;
        }

        [$controller, $method] = explode(separator: '@', string: $action);

        $reflection = new ReflectionMethod(objectOrMethod: $controller, method: $method);

        return collect($reflection->getParameters())->contains(function (ReflectionParameter $param) use ($injection) {
            $type = $param->getType();
            if (! $type || $type->isBuiltin()) {
                return false;
            }

            $className = $type->getName();

            return is_subclass_of(object_or_class: $className, class: $injection);
        });
    }
}
