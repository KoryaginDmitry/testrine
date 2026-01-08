<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc\OpenApi\Path\Method\Body;

use DkDev\Testrine\Doc\OpenApi\Path\Method\Scheme\Scheme;
use JsonSerializable;

class RequestBody implements JsonSerializable
{
    public function __construct(
        public ?Scheme $scheme = null,
        public string $contentType = 'application/json',
    ) {}

    public function jsonSerialize(): array
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
