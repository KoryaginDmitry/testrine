<?php

namespace DkDev\Testrine;

use DkDev\Testrine\Console\DestroyDataCommand;
use DkDev\Testrine\Console\GenerateCommand;
use DkDev\Testrine\Console\GenerateTestsCommand;
use DkDev\Testrine\Console\InitCommand;
use DkDev\Testrine\Console\MakeCommand;
use DkDev\Testrine\Console\ParseCommand;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(path: __DIR__.'/../resources/lang', namespace: 'testrine');

        $this->publishes(paths: [
            __DIR__.'/../public/swagger-ui' => public_path('swagger-ui'),
            __DIR__.'/../resources/views' => resource_path('views/swagger-ui'),
        ], groups: 'swagger');

        $this->publishes(paths: [
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/testrine'),
        ], groups: 'translations');

        $this->publishes(paths: [
            __DIR__.'/../config/testrine.php' => config_path('testrine.php'),
        ], groups: 'config');

        $this->loadRoutesFrom(path: __DIR__.'/../route/swagger.php');

        if ($this->app->runningInConsole()) {
            $this->commands(commands: [
                MakeCommand::class,
                InitCommand::class,
                GenerateTestsCommand::class,
                DestroyDataCommand::class,
                GenerateCommand::class,
                ParseCommand::class,
            ]);
        }
    }
}
