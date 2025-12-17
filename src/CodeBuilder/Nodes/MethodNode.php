<?php

declare(strict_types=1);

namespace Dkdev\Testrine\CodeBuilder\Nodes;

class MethodNode extends BaseNode
{
    public function __construct(
        public string $name,
        public array $args
    ) {}

    public function render(): string
    {
        return "->$this->name({$this->prepareArgs()})";
    }
}
