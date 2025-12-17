<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Data\OpenApi\Path\Method\Response;

use Dkdev\Testrine\Data\OpenApi\Path\Method\Scheme\Scheme;
use JsonSerializable;

class Code implements JsonSerializable
{
    public function __construct(
        public ?string $description = '',
        public ?Scheme $scheme = null,
        public string $contentType = 'application/json',
    ) {}

    public function jsonSerialize(): mixed
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
