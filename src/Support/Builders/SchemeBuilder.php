<?php

declare(strict_types=1);

namespace DkDev\Testrine\Support\Builders;

use DkDev\Testrine\Doc\OpenApi\Path\Method\Scheme\Property\Property;
use DkDev\Testrine\Doc\OpenApi\Path\Method\Scheme\Scheme;
use DkDev\Testrine\Enums\Attributes\Type;
use Illuminate\Support\Arr;

final class SchemeBuilder
{
    public static function makeScheme(array $data): Scheme
    {
        $scheme = new Scheme;

        foreach ($data as $item) {
            self::walkPath(
                parent: $scheme,
                path: explode('.', $item['name']),
                item: $item
            );
        }

        $scheme->example = self::makeExample($data);

        return $scheme;
    }

    private static function walkPath(
        Scheme|Property $parent,
        array $path,
        array $item
    ): void {
        $segment = array_shift($path);

        if (self::isIndex($segment)) {
            self::walkPath($parent, $path, $item);

            return;
        }

        if (empty($path)) {
            self::addScalar($parent, $segment, $item);

            return;
        }

        if (self::isIndex($path[0])) {
            $array = self::ensureArray($parent, $segment);
            self::walkPath($array->items, $path, $item);

            return;
        }

        $object = self::ensureObject($parent, $segment);
        self::walkPath($object, $path, $item);
    }

    private static function ensureArray(
        Scheme|Property $parent,
        string $key
    ): Property {
        return $parent->properties[$key] ??= new Property(
            type: Type::ARRAY->value,
            items: new Property(
                type: Type::OBJECT->value,
                properties: [],
            ),
        );
    }

    private static function ensureObject(
        Scheme|Property $parent,
        string $key
    ): Property {
        return $parent->properties[$key] ??= new Property(
            type: Type::OBJECT->value,
            properties: [],
        );
    }

    private static function addScalar(
        Scheme|Property $parent,
        ?string $key,
        array $item
    ): void {
        $nullable = array_key_exists('example', $item) && $item['example'] === null || empty($item['required']);

        $parent->properties[$key] ??= new Property(
            type: $item['type'],
            format: $item['format'],
            description: $item['description'],
            required: $item['required'] ?? null,
            nullable: $nullable,
            enum: $item['enum'] ?? null,
            example: $item['example'] ?? null
        );
    }

    private static function isIndex(mixed $value): bool
    {
        return ctype_digit((string) $value);
    }

    private static function makeExample(array $data): array
    {
        $dot = [];

        foreach ($data as $item) {
            $dot[$item['name']] = $item['example'];
        }

        return Arr::undot($dot);
    }

    public static function resolveType(mixed $value): string
    {
        return match (get_debug_type($value)) {
            'int' => Type::INTEGER->value,
            'float' => Type::NUMBER->value,
            'bool' => Type::BOOL->value,
            'null' => Type::STRING->value,
            default => get_debug_type($value),
        };
    }
}
