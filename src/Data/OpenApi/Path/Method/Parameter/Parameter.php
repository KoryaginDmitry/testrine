<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Data\OpenApi\Path\Method\Parameter;

use JsonSerializable;

class Parameter implements JsonSerializable
{
    public function __construct(
        public string $name,
        public string $in,
        public ?string $description,
        public bool $required,
        public string $type,
        public mixed $value,
    ) {}

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'name' => $this->name,
            'in' => $this->in,
            'description' => ! empty($this->description) ? $this->description : null,
            'required' => $this->required,
            'schema' => [
                'type' => $this->type,
            ],
            'example' => $this->value,
        ]);
    }
}
