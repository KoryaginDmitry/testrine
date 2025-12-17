<?php

namespace Dkdev\Testrine\Console;

use Dkdev\Testrine\Contracts\CodeContract;
use Dkdev\Testrine\Contracts\DocIgnoreContract;
use Dkdev\Testrine\Contracts\FakeStorageContract;
use Dkdev\Testrine\Contracts\InvalidateCodeContract;
use Dkdev\Testrine\Contracts\InvalidateContract;
use Dkdev\Testrine\Contracts\InvalidParametersCodeContract;
use Dkdev\Testrine\Contracts\InvalidParametersContract;
use Dkdev\Testrine\Contracts\JobContract;
use Dkdev\Testrine\Contracts\MockContract;
use Dkdev\Testrine\Contracts\NotificationContract;
use Dkdev\Testrine\Contracts\ParametersContract;
use Dkdev\Testrine\Contracts\SeedContract;
use Dkdev\Testrine\Contracts\ValidateContract;
use Dkdev\Testrine\Exceptions\RouteNotFoundException;
use Dkdev\Testrine\Generators\TestGenerator;
use Dkdev\Testrine\Inform\Inform;
use Dkdev\Testrine\Support\Builders\ClassNameBuilder;
use Dkdev\Testrine\Support\Builders\ContractsListBuilder;
use Dkdev\Testrine\Support\Infrastructure\Config;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Throwable;

use function Laravel\Prompts\error;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

class MakeCommand extends Command
{
    protected $signature = 'testrine:make {group?}';

    protected $description = 'Creates a class for testing';

    protected string $routeName;

    protected string $group;

    public function handle(): int
    {
        try {
            $this->setGroup();
            $this->setRouteName();

            TestGenerator::make(
                className: $this->getClassName(),
                contracts: $this->getContracts(),
                routeName: $this->routeName,
                middlewares: $this->getMiddlewares(),
                group: $this->group,
                rewrite: false,
            )->generate();

            Inform::print($this);

            return self::SUCCESS;
        } catch (Throwable $throwable) {
            error($throwable->getMessage());

            return self::FAILURE;
        }
    }

    protected function setGroup(): void
    {
        $this->group = $this->argument('group') ?: Arr::first(Config::getGroups());
    }

    protected function getClassName(): string
    {
        return text(
            label: __('testrine::console.make.write_class_name'),
            default: ClassNameBuilder::make($this->routeName, $this->group)->handle(),
            required: true,
            validate: fn (string $value) => match (true) {
                strlen($value) < 3 => __('validation.min.string', [
                    'attribute' => 'name',
                    'min' => 3,
                ]),
                strlen($value) > 255 => __('validation.max.string', [
                    'attribute' => 'name',
                    'min' => 255,
                ]),
                default => null
            },
        );
    }

    protected function setRouteName(): void
    {
        $this->routeName = suggest(
            label: __('testrine::console.make.write_route_name'),
            options: collect(Route::getRoutes())->map(function ($route) {
                return $route->getName();
            })->filter()->all(),
            placeholder: 'api.user.update',
        );
    }

    /**
     * @throws RouteNotFoundException
     */
    protected function getMiddlewares(): string
    {
        $route = Route::getRoutes()->getByName(name: $this->routeName);

        if (! $route) {
            throw new RouteNotFoundException(__('testrine::console.make.write_route_name', ['name' => $this->routeName]));
        }

        return text(
            label: __('testrine::console.make.write_middlewares'),
            placeholder: 'api, auth',
            default: implode(', ', $route->middleware() ?? [])
        );
    }

    protected function getContracts(): array
    {
        return multiselect(
            label: __('testrine::console.make.select_contracts'),
            options: [
                CodeContract::class,
                ValidateContract::class,
                InvalidateContract::class,
                InvalidateCodeContract::class,
                ParametersContract::class,
                InvalidParametersContract::class,
                InvalidParametersCodeContract::class,
                SeedContract::class,
                FakeStorageContract::class,
                JobContract::class,
                MockContract::class,
                NotificationContract::class,
                DocIgnoreContract::class,
            ],
            default: ContractsListBuilder::make($this->group, $this->routeName)
        );
    }
}
