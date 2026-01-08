<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc\OpenApi\Info\Contact;

class Contact
{
    public function __construct(
        public ?string $name,
        public ?string $url,
        public ?string $email,
    ) {}

    public static function fromArray(array $data): Contact
    {
        return new self(
            name: $data['name'] ?? null,
            url: $data['url'] ?? null,
            email: $data['email'] ?? null,
        );
    }
}
