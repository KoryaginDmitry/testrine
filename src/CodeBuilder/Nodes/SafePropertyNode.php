<?php

declare(strict_types=1);

namespace DkDev\Testrine\CodeBuilder\Nodes;

class SafePropertyNode extends BaseNode
{
    public function __construct(
        public string $name
    ) {}

    public function render(): string
    {
        return "?->$this->name";
    }
}
