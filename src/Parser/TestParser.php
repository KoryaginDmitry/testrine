<?php

namespace Dkdev\Testrine\Parser;

use Dkdev\Testrine\Attributes\Property;
use Dkdev\Testrine\Attributes\Resource;
use Dkdev\Testrine\Collectors\Collector;
use Dkdev\Testrine\Enums\Attributes\In;
use Dkdev\Testrine\Enums\Inform\Level;
use Dkdev\Testrine\Enums\Writes\Format;
use Dkdev\Testrine\Factories\WriterFactory;
use Dkdev\Testrine\Inform\Inform;
use Dkdev\Testrine\Support\Infrastructure\Config;
use Dkdev\Testrine\Support\Infrastructure\Reflection;
use Dkdev\Testrine\Traits\Makeable;
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

    public function makeAutoDoc(TestResponse $response): void
    {
        try {
            $this->collectAttributes();
            $this->makeData($response);
            $this->saveFile();

            Inform::push(__('success'));
        } catch (Throwable $throwable) {
            dd($throwable);
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

    protected function makeData(TestResponse $response): void
    {
        /**
         * @var string $key
         * @var Collector $collector
         */
        foreach (Config::getSwaggerValue('collectors') as $collector) {
            $collector = $collector::make(
                response: $response,
                attributes: $this->attributes
            );

            $this->data[$collector->getName()] = $collector->handle();
        }
    }

    protected function saveFile(): void
    {
        WriterFactory::make(Format::JSON)->write(
            path: Config::getSwaggerValue('storage.data.path'),
            name: request()->route()->getName().Str::random(10),
            data: $this->data,
        );
    }
}
