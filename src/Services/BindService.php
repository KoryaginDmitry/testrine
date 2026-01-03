<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Resolvers\Code\CodeResolver;
use DkDev\Testrine\Traits\HasContractRoutes;
use DkDev\Testrine\Traits\HasHandler;
use DkDev\Testrine\ValidData\Rules\BaseRule;

class BindService extends BaseService
{
    protected array $valid = [
        '*' => 1,
    ];

    protected array $invalid = [
        '*' => 999999,
    ];

    public function pushValid(?string $routeName, string $key, string|Builder $value): void
    {
        $value = $value instanceof Builder ? $value->build() : $value;

        if ($routeName) {
            $this->valid[$routeName][$key] = $value;
        } else {
            $this->valid[$key] = $value;
        }
    }

    public function pushInvalid(?string $routeName, string $key, string $value): void
    {
        if ($routeName) {
            $this->invalid[$routeName][$key] = $value;
        } else {
            $this->invalid[$key] = $value;
        }
    }

    public function getValid(string $routeName, string $key): int|string
    {
        if (isset($this->valid[$routeName][$key])) {
            return ''.$this->valid[$routeName][$key];
        }

        return isset($this->valid[$key]) ? ''.$this->valid[$key] : ''.$this->valid['*'];
    }

    public function getInvalid(string $routeName, string $key): int|string
    {
        if (isset($this->invalid[$routeName][$key])) {
            return ''.$this->invalid[$routeName][$key];
        }

        return isset($this->invalid[$key])
            ? ''.$this->invalid[$key]
            : ''.$this->invalid['*'];
    }

    public function setDefaultValue(string $routeName, string $key, int|string|Builder $value): void
    {
        BaseRule::setDefaultValue(
            routeName: $routeName,
            key: $key,
            value: $value
        );
    }

    /**
     * @param  class-string<HasContractRoutes>  $contract
     */
    public function setContractRoutes(string $contract, array $routes): void
    {
        $contract::setContractRoutes(routes: $routes);
    }

    public function setDefaultCode(string $resolver, string $routeName, int $value): void
    {
        CodeResolver::setDefaultCode(resolver: $resolver, routeName: $routeName, code: $value);
    }

    /**
     * @param  class-string<HasHandler>  $handler
     */
    public function setHandler(string $handler, \Closure $closure): void
    {
        $handler::setHandler($closure);
    }
}
