<?php

namespace DkDev\Testrine\Parser;

use DkDev\Testrine\Attributes\Property;
use DkDev\Testrine\Attributes\Resource;
use DkDev\Testrine\Collectors\Collector;
use DkDev\Testrine\Enums\Attributes\In;
use DkDev\Testrine\Enums\Inform\Level;
use DkDev\Testrine\Enums\Writes\Format;
use DkDev\Testrine\Factories\WriterFactory;
use DkDev\Testrine\Inform\Inform;
use DkDev\Testrine\Support\Infrastructure\Config;
use DkDev\Testrine\Support\Infrastructure\Reflection;
use DkDev\Testrine\Traits\Makeable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use Throwable;

/**
 * @method static TestParser make()
 */
class TestParser
{
    use Makeable;

    protected array $data = [];

    protected ?Collection $attributes = null;

    protected bool $isset = false;

    public function makeAutoDoc(TestResponse $response, string $group): void
    {
        try {
            $this->collectAttributes();
            $this->makeData($response, $group);
            $this->saveFile();

            Inform::push(__('success'));
        } catch (Throwable $throwable) {
            Inform::push(__('error', [
                'error' => $throwable->getMessage(),
            ]), Level::WARNING);
        }
    }

    /**
     * @throws ReflectionException
     */
    protected function collectAttributes(): void
    {
        $reflection = Reflection::make();

        $arguments = array_merge(
            $this->getClassAttributes($reflection->getFormRequest()),
            $this->parseResources($reflection->getJsonResourceClass()[0] ?? null),
            $reflection->method->getAttributes(),
            $reflection->controller->getAttributes(),
        );

        $this->attributes = collect();

        /** @var ReflectionAttribute|Property $argument */
        foreach ($arguments as $argument) {
            if ($argument instanceof ReflectionAttribute) {
                $class = $argument->getName();

                $this->attributes->push(
                    new $class(...$argument->getArguments())
                );
            } else {
                $this->attributes->push($argument);
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    protected function getClassAttributes($class): array
    {
        return $class ? (new ReflectionClass($class))->getAttributes() : [];
    }

    /**
     * @throws ReflectionException
     */
    protected function parseResources(?string $class, string $prefix = ''): array
    {
        if (! $class) {
            return [];
        }

        $attributes = $this->getClassAttributes($class);
        if (! $attributes) {
            return [];
        }

        $result = [];

        foreach ($attributes as $attribute) {
            $name = $attribute->getName();
            $args = $attribute->getArguments();

            if ($name === Resource::class) {
                $this->isset = true;
                $nestedClass = $args['name'];
                $nestedKey = $args['key'];

                $nestedPrefix = $prefix.$nestedKey.'.';
                $result = array_merge($result, $this->parseResources($nestedClass, $nestedPrefix));

                continue;
            }

            if ($name === Property::class) {
                $this->isset = true;
                $property = new Property(
                    ...array_merge($args, [
                        'name' => $prefix.$args['name'],
                        'in' => In::RESPONSE,
                    ])
                );

                $result[] = $property;

                continue;
            }

            $result[] = $attribute;
        }

        return $result;
    }

    protected function makeData(TestResponse $response, string $group): void
    {
        /**
         * @var string $key
         * @var Collector $collector
         */
        foreach (Config::getDocsValue('collectors') as $collector) {
            $collector = $collector::make(
                response: $response,
                attributes: $this->attributes,
                group: $group,
            );

            $this->data[$collector->getName()] = $collector->handle();
        }
    }

    protected function saveFile(): void
    {
        WriterFactory::make(Format::JSON)->write(
            path: Config::getDocsValue('storage.data.path'),
            name: request()->route()->getName().Str::random(10),
            data: $this->data,
        );
    }
}
