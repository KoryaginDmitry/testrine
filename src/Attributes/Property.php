<?php

namespace Dkdev\Testrine\Attributes;

use Attribute;
use Dkdev\Testrine\Enums\Attributes\In;
use Dkdev\Testrine\Enums\Attributes\Type;
use Dkdev\Testrine\Interfaces\FormatInterface;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
class Property
{
    public function __construct(
        public string $name,
        public Type $type,
        public ?FormatInterface $format = null,
        public ?In $in = null,
        public mixed $example = null,
        public ?string $description = null,
        public null|string|array $enum = null,
        public ?bool $required = null,
    ) {}
}
