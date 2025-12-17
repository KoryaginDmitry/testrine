<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

use BackedEnum;
use DkDev\Testrine\Attributes\Property;
use DkDev\Testrine\Enums\Attributes\In;
use DkDev\Testrine\Enums\Attributes\StringFormat;
use DkDev\Testrine\Enums\Attributes\Type;
use DkDev\Testrine\Support\Infrastructure\Reflection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RequestCollector extends Collector
{
    protected array $result = [];

    public function getName(): string
    {
        return 'request';
    }

    protected function parseBody(array $rules): void
    {
        $json = json_decode(request()->getContent(), true);
        if (! is_array($json)) {
            return;
        }

        foreach ($json as $name => $value) {
            $property = $this->findProperty(attributes: $this->attributes, name: $name, excluded: [In::PATH, In::RESPONSE]);

            $in = $property?->in ?? ($this->isGet() ? In::QUERY : In::BODY);

            $this->addResult(property: $property, name: $name, value: $value, in: $in, rules: $rules);
        }
    }

    protected function parsePathParams(array $rules): void
    {
        foreach ($this->getRoute()?->parameters() ?? [] as $name => $value) {
            $property = $this->findProperty(attributes: $this->attributes, name: $name, only: [In::PATH]);

            $this->addResult(property: $property, name: $name, value: $value, in: In::PATH, rules: $rules);
        }
    }

    protected function findProperty(Collection $attributes, string $name, array $only = [], array $excluded = []): ?Property
    {
        return $attributes->filter(function ($item) use ($name, $only, $excluded) {
            if (! $item instanceof Property) {
                return false;
            }

            if (! empty($only) && ! in_array($item->in, $only)) {
                return false;
            }

            if (! empty($excluded) && in_array($item->in, $excluded)) {
                return false;
            }

            return $item->name === $name;
        })
            ->last();
    }

    protected function addResult(?Property $property, string $name, mixed $value, In $in, array $rules): void
    {
        $this->result[] = [
            'name' => $name,
            'example' => $property?->example ?? ($value instanceof Model ? $value->getKey() : $value),
            'type' => $this->resolveType($property, $value),
            'format' => $this->resolveFormat($property, $name, $rules),
            'in' => $in->value,
            'description' => $property?->description,
            'enum' => $this->resolveEnum($property),
            'required' => $this->resolveRequired($property, $name, $rules) || $in === In::PATH,
        ];
    }

    protected function resolveType(?Property $property, mixed $value): string
    {
        if ($property?->type?->value) {
            return $property?->type?->value;
        }

        if ($value instanceof Model) {
            return Type::STRING->value;
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

    protected function resolveRequired(?Property $property, string $name, array $rules): bool
    {
        if ($property?->required !== null) {
            return $property->required;
        }

        return in_array('required', $rules[$name] ?? [], true);
    }

    protected function resolveFormat(?Property $property, string $name, array $rules): ?string
    {
        if (isset($property->format)) {
            return $property->format->value;
        }

        if (in_array('file', $rules[$name] ?? [], true) || in_array('image', $rules[$name] ?? [], true)) {
            return StringFormat::BINARY->value;
        }

        return null;
    }

    protected function isGet(): bool
    {
        return request()->method() === 'GET';
    }

    public function defaultHandler(): mixed
    {
        $rules = Reflection::make()->getFormRequestRules();

        $this->parseBody($rules);
        $this->parsePathParams($rules);

        return $this->result;
    }
}
