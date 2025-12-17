<?php

declare(strict_types=1);

namespace Dkdev\Testrine\CodeBuilder;

use Dkdev\Testrine\CodeBuilder\Nodes\BaseNode;
use Dkdev\Testrine\Traits\Makeable;

class Renderer
{
    use Makeable;

    public function render(string $root, array $nodes): string
    {
        $code = $root;

        /** @var BaseNode $node */
        foreach ($nodes as $node) {
            $code .= $node->render();
        }

        return $code;
    }

    public static function export(mixed $arg): string
    {
        return match (true) {
            $arg instanceof Builder => $arg->build(),
            is_string($arg) => "'".addslashes($arg)."'",
            is_null($arg) => 'null',
            is_bool($arg) => $arg ? 'true' : 'false',
            default => var_export($arg, true),
        };
    }
}
