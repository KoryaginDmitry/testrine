<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Data\OpenApi\Info\License;

class License
{
    public function __construct(
        public string $name,
        public string $url,
    ) {}

    public static function fromArray(array $data): License
    {
        return new self(
            name: $data['name'],
            url: $data['url'],
        );
    }
}
