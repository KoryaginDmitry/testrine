<?php

declare(strict_types=1);

namespace DkDev\Testrine\Data\OpenApi\Info\Contact;

class Contact
{
    public function __construct(
        public string $name,
        public string $url,
        public string $email,
    ) {}

    public static function fromArray(array $data): Contact
    {
        return new self(
            name: $data['name'],
            url: $data['url'] ?? '',
            email: $data['email'] ?? '',
        );
    }
}
