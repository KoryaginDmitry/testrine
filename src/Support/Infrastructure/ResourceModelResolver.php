<?php

declare(strict_types=1);

namespace DkDev\Testrine\Support\Infrastructure;

use DkDev\Testrine\Traits\Makeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionException;

/**
 * @method static ResourceModelResolver make(string $resourceClass)
 */
class ResourceModelResolver
{
    use Makeable;

    public function __construct(protected string $resourceClass) {}

    /**
     * @throws ReflectionException
     */
    public function findModel()
    {
        if ($mixinModel = $this->getMixinModel()) {
            return new $mixinModel;
        }

        $models = $this->scanModels(app_path('Models'));

        if (empty($models)) {
            return null;
        }

        $resourceShort = class_basename($this->resourceClass);
        $parts = preg_split('/(?=[A-Z])/', $resourceShort, -1, PREG_SPLIT_NO_EMPTY);

        while (count($parts) > 0) {
            $candidate = implode('', $parts);

            foreach ($models as $model) {
                if (Str::endsWith($model, '\\'.$candidate)) {
                    return $model;
                }
            }

            array_pop($parts);
        }

        return null;
    }

    /**
     * @throws ReflectionException
     */
    protected function getMixinModel(): ?string
    {
        $reflection = new ReflectionClass($this->resourceClass);
        $doc = $reflection->getDocComment();

        if (! $doc) {
            return null;
        }

        preg_match_all('/^use\s+([^;]+);/mi', file_get_contents($reflection->getFileName()), $matches);

        $result = [];

        if (! empty($matches[1])) {
            foreach ($matches[1] as $use) {
                $parts = array_map('trim', explode(',', $use));

                foreach ($parts as $part) {
                    if (stripos($part, ' as ') !== false) {
                        [$path, $alias] = preg_split('/\s+as\s+/i', $part);
                    } else {
                        $path = $part;
                        $alias = basename(str_replace('\\', '/', $path));
                    }

                    $result[$alias] = $path;
                }
            }
        }

        if (preg_match('/@mixin\s+([\w\\\\]+)/', $doc, $m)) {
            return $result[$m[1]] ?? null;
        }

        return null;
    }

    protected function scanModels(string $directory): array
    {
        $models = [];

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $path = $file->getRealPath();
            $class = $this->classFromFilePath($path);

            if ($class && is_subclass_of($class, Model::class)) {
                $models[] = $class;
            }
        }

        return $models;
    }

    protected function classFromFilePath(string $path): ?string
    {
        $content = file_get_contents($path);
        if (! $content) {
            return null;
        }

        if (! preg_match('/namespace\s+(.+?);/', $content, $ns)) {
            return null;
        }
        if (! preg_match('/class\s+(\w+)/', $content, $cl)) {
            return null;
        }

        return $ns[1].'\\'.$cl[1];
    }
}
