<?php

declare(strict_types=1);

namespace DkDev\Testrine\Console;

use DkDev\Testrine\Exceptions\TestAlreadyExistException;
use DkDev\Testrine\Generators\TestGenerator;
use DkDev\Testrine\Inform\Inform;
use DkDev\Testrine\Support\Builders\ClassNameBuilder;
use DkDev\Testrine\Support\Builders\ContractsListBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Throwable;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multiselect;

class GenerateTestsCommand extends Command
{
    protected $signature = 'testrine:tests
                                {--R|rewrite : rewrite tests}';

    protected $description = 'Covers the application with tests';

    public function handle(): int
    {
        try {
            $routes = collect(value: Route::getRoutes())->map(fn (\Illuminate\Routing\Route $route) => [
                'group' => Str::before(subject: $route->getName(), search: '.'),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
            ])->filter(fn (array $data) => ! empty($data['name']));

            $grouped = $routes->groupBy('group');

            $groups = multiselect(
                label: __('testrine::console.tests.select_route_groups'),
                options: $grouped->keys()
            );

            $selectedGrouped = $grouped->filter(fn (Collection $routes, string $group) => in_array($group, $groups));
            $selectedRoutes = collect();

            foreach ($selectedGrouped as $group => $routes) {
                $routes = collect($routes);

                $selected = multiselect(
                    label: __('testrine::console.tests.select_routes_by_group', ['group' => $group]),
                    options: $routes->pluck('name')->toArray(),
                    default: $routes->pluck('name')->toArray(),
                );

                $selectedRoutes = $selectedRoutes->merge(
                    items: $routes->filter(fn (array $route) => in_array($route['name'], $selected))
                );
            }

            foreach ($selectedRoutes as $route) {
                $rewrite = (bool) $this->option('rewrite');

                try {
                    $this->makeGenerator(route: $route, rewrite: $rewrite)->generate();
                } catch (TestAlreadyExistException $e) {
                    $rewrite = $this->confirm(
                        __('testrine::console.make.test_already_exists', ['path' => $e->path])
                    );

                    if (! $rewrite) {
                        info(__('testrine::console.make.skipped', ['path' => $e->path]));

                        continue;
                    }

                    $this->makeGenerator(route: $route, rewrite: true)->generate();
                }

                Inform::print($this);
            }

            return self::SUCCESS;
        } catch (Throwable $throwable) {
            error($throwable->getMessage());

            return self::FAILURE;
        }
    }

    private function makeGenerator(array $route, bool $rewrite = false): TestGenerator
    {
        return new TestGenerator(
            className: ClassNameBuilder::make($route['name'], $route['group'])->handle(),
            contracts: ContractsListBuilder::make($route['group'], $route['name']),
            routeName: $route['name'],
            middlewares: implode(', ', Route::getRoutes()->getByName($route['name'])->middleware() ?? []),
            group: $route['group'],
            rewrite: $rewrite,
        );
    }
}
