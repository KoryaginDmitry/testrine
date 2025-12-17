<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Data\OpenApi\Path\Method\Body;

use Dkdev\Testrine\Data\OpenApi\Path\Method\Scheme\Scheme;
use JsonSerializable;

class RequestBody implements JsonSerializable
{
    public function __construct(
        public ?Scheme $scheme = null,
        public string $contentType = 'application/json',
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'content' => [
                'application/json' => [
                    'schema' => $this->scheme,
                ],
            ],
        ];
    }
}
