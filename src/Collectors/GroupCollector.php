<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Collectors;

use Dkdev\Testrine\Attributes\Group;
use Dkdev\Testrine\Support\Infrastructure\Reflection;

class GroupCollector extends Collector
{
    public function getName(): string
    {
        return 'group';
    }

    public function defaultHandler(): mixed
    {
        $attributeName = $this->attributes
            ->filter(fn ($item) => $item instanceof Group)
            ->last()
            ?->name;

        $defaultName = str(
            Reflection::make()->controller->getName()
        )
            ->afterLast('\\')
            ->before('Controller')
            ->value();

        return $attributeName ?: $defaultName;
    }
}
