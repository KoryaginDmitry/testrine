<?php

namespace DkDev\Testrine\Support\Infrastructure;

use DkDev\Testrine\Attributes\Resource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Route;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use stdClass;

class Reflection
{
    public function __construct(
        public ReflectionClass $controller,
        public ReflectionMethod $method,
        public Route $route,
    ) {}

    /**
     * @throws ReflectionException
     */
    public static function make(?Route $route = null): static
    {
        if (! $route) {
            $route = request()->route();
        }

        [$class, $method] = explode('@', $route->getAction('controller'));

        $controller = new ReflectionClass($class);

        return new static($controller, $controller->getMethod($method), $route);
    }

    public function getFormRequest(): ?FormRequest
    {
        foreach ($this->method->getParameters() as $parameter) {
            $formRequest = $this->instantiateFormRequestIfExists($parameter);

            if ($formRequest) {
                return $formRequest;
            }
        }

        return null;
    }

    /**
     * @throws ReflectionException
     */
    public function getFormRequestRules(): array
    {
        $formRequest = $this->getFormRequest();

        if (! $formRequest) {
            return [];
        }

        foreach (\DkDev\Testrine\Support\Infrastructure\Route::getParametersByUrl($this->route->uri()) as $urlParam) {
            $prop = trim($urlParam, '{}');
            $formRequest->{$prop} = $this->mockRouteValue();
        }

        return $formRequest->rules();
    }

    public function getMethodParameters(): array
    {
        $params = [];

        foreach ($this->method->getParameters() as $p) {
            $params[$p->getName()] = [
                'type' => $p->getType()?->getName(),
                'builtin' => $p->getType()?->isBuiltin() ?? false,
                'nullable' => $p->getType()?->allowsNull() ?? false,
                'has_default' => $p->isDefaultValueAvailable(),
                'default' => $p->isDefaultValueAvailable() ? $p->getDefaultValue() : null,
                'attributes' => $this->mapAttributes($p->getAttributes()),
            ];
        }

        return $params;
    }

    /**
     * @return null|array<ReflectionNamedType>
     */
    public function getReturnTypes(): ?array
    {
        $types = $this->method->getReturnType();

        if ($types instanceof ReflectionNamedType) {
            return [$types];
        }

        return $types?->getTypes();
    }

    public function getMethodAttributes(): array
    {
        return $this->mapAttributes($this->method->getAttributes());
    }

    public function getControllerAttributes(): array
    {
        return $this->mapAttributes($this->controller->getAttributes());
    }

    public function getJsonResourceClass(): ?array
    {
        $isCollection = false;

        foreach ($this->getReturnTypes() as $type) {
            $class = $type->getName();

            if (! $isCollection) {
                $isCollection = $class === AnonymousResourceCollection::class;
            }

            if (! $isCollection && class_exists($class) && is_subclass_of($class, JsonResource::class)) {
                return [$type->getName(), false];
            }
        }

        foreach ($this->getMethodAttributes() as $attribute) {
            if ($attribute['name'] === Resource::class) {
                return [$attribute['args'][0], $isCollection];
            }
        }

        return null;
    }

    protected function mockRouteValue(): stdClass
    {
        return (object) ['id' => 1];
    }

    /**
     * @throws ReflectionException
     */
    protected function instantiateFormRequestIfExists(ReflectionParameter $parameter): ?FormRequest
    {
        $type = $parameter->getType()?->getName();
        if (! $type || ! class_exists($type)) {
            return null;
        }

        $reflection = new ReflectionClass($type);
        if (! $reflection->isSubclassOf(FormRequest::class)) {
            return null;
        }

        return $reflection->newInstance();
    }

    protected function mapAttributes(array $attributes): array
    {
        return array_map(
            fn (ReflectionAttribute $attr) => [
                'name' => $attr->getName(),
                'args' => $attr->getArguments(),
            ],
            $attributes
        );
    }
}
