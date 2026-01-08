<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc\OpenApi\Path\Method\Response;

use DkDev\Testrine\Doc\OpenApi\Path\Method\Scheme\Scheme;
use JsonSerializable;

class Code implements JsonSerializable
{
    public function __construct(
        public ?string $description = '',
        public ?Scheme $scheme = null,
        public string $contentType = 'application/json',
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'content' => [
                $this->contentType => [
                    'schema' => (array) $this->scheme,
                ],
            ],
        ];
    }
}
