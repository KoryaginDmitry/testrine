<?php

declare(strict_types=1);

namespace Dkdev\Testrine\CodeBuilder\Nodes;

use Dkdev\Testrine\CodeBuilder\Renderer;

abstract class BaseNode
{
    abstract public function render(): string;

    protected function prepareArgs(): string
    {
        return implode(', ', array_map([Renderer::class, 'export'], $this->args));
    }
}
