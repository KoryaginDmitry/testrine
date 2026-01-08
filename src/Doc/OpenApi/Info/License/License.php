<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc\OpenApi\Info\License;

class License
{
    public function __construct(
        public ?string $name,
        public ?string $url,
    ) {}

    public static function fromArray(array $data): License
    {
        return new self(
            name: $data['name'] ?? null,
            url: $data['url'] ?? null,
        );
    }
}
