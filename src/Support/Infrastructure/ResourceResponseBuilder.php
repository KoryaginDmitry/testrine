<?php

declare(strict_types=1);

namespace DkDev\Testrine\Support\Infrastructure;

use DkDev\Testrine\Enums\Inform\Level;
use DkDev\Testrine\Inform\Inform;
use DkDev\Testrine\Support\Char;
use DkDev\Testrine\Traits\Makeable;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

/**
 * @method static ResourceResponseBuilder make(JsonResource $resource, bool $isCollection)
 */
class ResourceResponseBuilder
{
    use Makeable;

    public function __construct(protected JsonResource $resource, protected bool $isCollection) {}

    public function build(): string
    {
        try {
            $data = method_exists($this->resource, 'toArray')
                ? $this->resource->toArray(request())
                : (array) $this->resource;
        } catch (Throwable $throwable) {
            Inform::push(
                message: __('testrine::console.test.errors.resource.parse', [
                    'resource' => get_class($this->resource),
                    'error' => $throwable->getMessage(),
                ]),
                level: Level::WARNING
            );

            $data = [];
        }

        return $this->prepareStructure(
            $this->getStructure(array_keys($data))
        );
    }

    protected function getStructure(array $data): array
    {
        return match (true) {
            $this->resource::$wrap && $this->isCollection => [
                $this->resource::$wrap => ['*' => $data],
            ],
            $this->resource::$wrap && ! $this->isCollection => [
                $this->resource::$wrap => $data,
            ],
            ! $this->resource::$wrap && $this->isCollection => [
                '*' => $data,
            ],
            ! $this->resource::$wrap && ! $this->isCollection => [
                $data,
            ],
        };
    }

    protected function prepareStructure(array $array, int $level = 0): string
    {
        $tabs = Char::NL_TAB3.str_repeat(Char::TAB, $level);
        $result = '';

        foreach ($array as $key => $value) {
            $result .= $this->formatValue($key, $value, $level);
        }

        return rtrim($result, $tabs);
    }

    private function formatValue(mixed $key, mixed $value, int $level): string
    {
        $tabs = Char::NL_TAB3.str_repeat(Char::TAB, $level);

        if (is_array($value)) {
            $nextLevel = $level + 1;
            $content = $this->prepareStructure($value, $nextLevel);
            $prefix = $level > 0 ? Char::TAB : '';

            return "$prefix'$key' => [$tabs$content$tabs],$tabs";
        }

        $prefix = ($key === 0 && $level > 0) ? Char::TAB : '';

        return "$prefix'$value',$tabs";
    }
}
