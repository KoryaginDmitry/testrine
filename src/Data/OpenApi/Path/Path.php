<?php

declare(strict_types=1);

namespace DkDev\Testrine\Data\OpenApi\Path;

use DkDev\Testrine\Data\OpenApi\Path\Method\Method;
use JsonSerializable;

class Path implements JsonSerializable
{
    /**
     * @param  array<string, Method>  $methods
     */
    public function __construct(
        public array $methods = []
    ) {}

    public function jsonSerialize(): mixed
    {
        return $this->methods;
    }
}
