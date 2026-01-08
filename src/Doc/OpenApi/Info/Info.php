<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc\OpenApi\Info;

use DkDev\Testrine\Doc\OpenApi\Info\Contact\Contact;
use DkDev\Testrine\Doc\OpenApi\Info\License\License;

class Info
{
    public function __construct(
        public ?string $title,
        public ?string $description,
        public ?string $version,
        public Contact $contact,
        public License $license,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            version: $data['version'] ?? null,
            contact: Contact::fromArray($data['contact'] ?? null),
            license: License::fromArray($data['license'] ?? null),
        );
    }
}
