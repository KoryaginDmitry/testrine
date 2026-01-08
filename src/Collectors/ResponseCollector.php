<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

use BackedEnum;
use DkDev\Testrine\Attributes\Property;
use DkDev\Testrine\Enums\Attributes\In;
use DkDev\Testrine\Enums\Attributes\StringFormat;
use DkDev\Testrine\Enums\Attributes\Type;
use Illuminate\Support\Collection;

class ResponseCollector extends Collector
{
    protected array $result = [];

    public function getName(): string
    {
        return 'response';
    }

    protected function parse(array $data, string $key, Collection $attributes): array
    {
        $result = [];

        foreach ($data as $name => $value) {
            $name = $key.$name;

            $property = $attributes->filter(fn (Property $item) => $item->name === $name)->last();

            if (is_array($value) || is_object($value)) {
                $result = array_merge($result, $this->parse($value, $name.'.', $attributes));
            } else {
                $result[] = [
                    'name' => $name,
                    'example' => $property?->example ?? $value,
                    'type' => $this->resolveType($property, $value),
                    'format' => $this->resolveFormat($property, $value),
                    'in' => In::RESPONSE->value,
                    'description' => $property?->description,
                    'enum' => $this->resolveEnum($property),
                    'required' => $property?->required || ! empty($value),
                ];
            }
        }

        return $result;
    }

    protected function resolveType(?Property $property, mixed $value): string
    {
        if ($property?->type?->value) {
            return $property?->type?->value;
        }

        return match (get_debug_type($value)) {
            'int' => Type::INTEGER->value,
            'float' => Type::NUMBER->value,
            'bool' => Type::BOOL->value,
            'null' => Type::STRING->value,
            default => get_debug_type($value),
        };
    }

    protected function resolveEnum(?Property $property): ?array
    {
        $enum = $property?->enum;

        return match (true) {
            is_array($enum) => $enum,
            is_string($enum) && enum_exists($enum) => array_map(
                callback: fn ($case) => $case instanceof BackedEnum ? $case->value : $case->name,
                array: $enum::cases()
            ),
            is_string($enum) => [$enum],
            default => null,
        };
    }

    protected function resolveFormat(?Property $property, mixed $value): ?string
    {
        if (isset($property->format)) {
            return $property->format->value;
        }

        if (! mb_detect_encoding((string) $value, 'UTF-8', true)) {
            return StringFormat::BINARY->value;
        }

        return null;
    }

    public function defaultHandler(): array
    {
        $attributes = $this->attributes->filter(function ($attribute) {
            return $attribute instanceof Property && $attribute->in === In::RESPONSE;
        });

        return $this->parse(
            data: json_decode($this->response->content(), true) ?? [],
            key: '',
            attributes: $attributes,
        );
    }
}
