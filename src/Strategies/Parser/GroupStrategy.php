<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use DkDev\Testrine\Attributes\Group;
use DkDev\Testrine\Helpers\Reflection;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use ReflectionException;

class GroupStrategy extends BaseParserStrategy
{
    public function getName(): string
    {
        return 'group';
    }

    /**
     * @throws ReflectionException
     */
    public function analyze(TestResponse $response, Collection $attributes): mixed
    {
        $attributeName = $attributes
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
