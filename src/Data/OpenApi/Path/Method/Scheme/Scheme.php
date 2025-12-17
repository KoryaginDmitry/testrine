<?php

declare(strict_types=1);

namespace DkDev\Testrine\Data\OpenApi\Path\Method\Scheme;

use DkDev\Testrine\Data\OpenApi\Path\Method\Scheme\Property\Property;
use JsonSerializable;
use stdClass;

class Scheme implements JsonSerializable
{
    /**
     * @param  array<string, Property>  $properties
     */
    public function __construct(
        public string $type = 'object',
        public array $properties = [],
        public array $example = [],
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'type' => $this->type,
            'properties' => ! empty($this->properties) ? $this->properties : new stdClass,
            'example' => $this->example,
        ];
    }
}
