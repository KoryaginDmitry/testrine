<?php

namespace DkDev\Testrine\Support\Infrastructure;

use Illuminate\Support\Collection;

class Config
{
    public static function getGroups(bool $withDefault = false): array
    {
        return collect(config('testrine.groups'))
            ->keys()
            ->when(! $withDefault, fn (Collection $collection) => $collection->reject(fn ($key) => $key === 'default'))
            ->values()
            ->all();
    }

    public static function getGroupValue(string $group, ?string $key = null): mixed
    {
        $default = (array) config(key: 'testrine.groups.default', default: []);
        $groupConfig = (array) config(key: "testrine.groups.$group", default: []);

        $config = array_replace_recursive($default, $groupConfig);

        return $key
            ? data_get(target: $config, key: $key)
            : $config;
    }

    public static function getDocsValue(string $path, mixed $default = null): mixed
    {
        return config('testrine.docs.'.$path, $default);
    }
}
