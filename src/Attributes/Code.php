<?php

namespace Dkdev\Testrine\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Code
{
    public function __construct(
        public string $code,
        public ?string $description = null,
    ) {}
}
