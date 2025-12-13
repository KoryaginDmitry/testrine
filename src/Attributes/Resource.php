<?php

namespace DkDev\Testrine\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Resource
{
    public function __construct(
        public string $name,
        public ?string $key = null,
    ) {
        $this->key = $this->makeResourceKey();
    }

    protected function makeResourceKey(): string
    {
        if ($this->key) {
            return $this->key;
        }

        return str($this->name)
            ->afterLast('\\')
            ->replace(['Resource', 'Collection'], '')
            ->snake()
            ->lower();
    }
}
