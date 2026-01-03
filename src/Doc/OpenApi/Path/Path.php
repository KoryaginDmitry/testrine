<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc\OpenApi\Path;

use DkDev\Testrine\Doc\OpenApi\Path\Method\Method;
use JsonSerializable;

class Path implements JsonSerializable
{
    /**
     * @param  array<string, Method>  $methods
     */
    public function __construct(
        public array $methods = []
    ) {}

    public function jsonSerialize(): array
    {
        return $this->methods;
    }
}
