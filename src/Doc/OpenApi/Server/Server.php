<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc\OpenApi\Server;

class Server
{
    public function __construct(
        public string $url,
        public string $description,
    ) {}

    public static function fromArray(array $data): Server
    {
        return new self(
            url: $data['url'],
            description: $data['description'],
        );
    }
}
