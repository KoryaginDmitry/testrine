<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Data\OpenApi\Path\Method\Scheme\Property;

use JsonSerializable;

class Property implements JsonSerializable
{
    /**
     * @param  ?Property[]  $properties
     */
    public function __construct(
        public string $type,
        public ?string $format = null,
        public ?string $description = null,
        public bool|array $required = false,
        public bool $nullable = true,
        public ?array $enum = null,
        public ?array $properties = null,
        public ?Property $items = null,
        public mixed $example = null,
    ) {}

    public static function fromArray(array $data): Property
    {
        return new self(
            type: $data['type'],
            format: $data['format'] ?? null,
            description: $data['description'] ?? null,
            required: $data['required'] ?? false,
            nullable: ! $data['required'],
            enum: $data['enum'] ?? null,
            properties: $data['properties'] ?? null,
            items: $data['items'] ?? null,
            example: $data['example'] ?? null,
        );
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'type' => $this->type,
            'format' => $this->format,
            'description' => $this->description,
            'required' => $this->required,
            'nullable' => $this->nullable,
            'enum' => $this->enum,
            'properties' => ! empty($this->properties) ? $this->properties : null,
            'items' => $this->items,
            'example' => ! empty($this->example) ? $this->example : null,
        ]);
    }
}
