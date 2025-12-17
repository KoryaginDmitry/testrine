<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Data\OpenApi\Info;

use Dkdev\Testrine\Data\OpenApi\Info\Contact\Contact;
use Dkdev\Testrine\Data\OpenApi\Info\License\License;

class Info
{
    public function __construct(
        public string $title,
        public string $description,
        public string $version,
        public Contact $contact,
        public License $license,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            version: $data['version'],
            contact: Contact::fromArray($data['contact']),
            license: License::fromArray($data['license']),
        );
    }
}
