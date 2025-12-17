<?php

declare(strict_types=1);

namespace DkDev\Testrine\CodeBuilder\Nodes;

class SafeMethodNode extends BaseNode
{
    public function __construct(
        public string $name,
        public array $args
    ) {}

    public function render(): string
    {
        return "?->$this->name({$this->prepareArgs()})";
    }
}
