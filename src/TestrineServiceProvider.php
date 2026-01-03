<?php

namespace DkDev\Testrine;

use DkDev\Testrine\Console\DestroyDataCommand;
use DkDev\Testrine\Console\GenerateCommand;
use DkDev\Testrine\Console\GenerateTestsCommand;
use DkDev\Testrine\Console\InitCommand;
use DkDev\Testrine\Console\MakeCommand;
use DkDev\Testrine\Console\ParseCommand;
use DkDev\Testrine\Enums\Doc\Renderer;
use DkDev\Testrine\Exceptions\RendererNotFound;
use DkDev\Testrine\Renders\BaseRender;
use DkDev\Testrine\Renders\SwaggerRender;
use DkDev\Testrine\Support\Infrastructure\Config;
use DkDev\Testrine\ValidData\Rules\ArrayRule;
use DkDev\Testrine\ValidData\Rules\BooleanRule;
use DkDev\Testrine\ValidData\Rules\CurrentPasswordRule;
use DkDev\Testrine\ValidData\Rules\DateRule;
use DkDev\Testrine\ValidData\Rules\EmailRule;
use DkDev\Testrine\ValidData\Rules\EnumRule;
use DkDev\Testrine\ValidData\Rules\FileRule;
use DkDev\Testrine\ValidData\Rules\ImageRule;
use DkDev\Testrine\ValidData\Rules\IntegerRule;
use DkDev\Testrine\ValidData\Rules\NullableRule;
use DkDev\Testrine\ValidData\Rules\PasswordRule;
use DkDev\Testrine\ValidData\Rules\RegexRule;
use DkDev\Testrine\ValidData\Rules\StringRule;
use DkDev\Testrine\ValidData\Rules\TableExistsRule;
use DkDev\Testrine\ValidData\Rules\UrlRule;
use Illuminate\Support\ServiceProvider;

class TestrineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/testrine.php',
            'testrine'
        );

        $this->app->bind(BaseRender::class, function () {
            return match (Config::getDocsValue('renderer')) {
                Renderer::SWAGGER => app(SwaggerRender::class),
                default => throw new RendererNotFound,
            };
        });
    }

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

        $this->setRules();
    }

    protected function setRules(): void
    {

        Testrine::rules()->set([
            NullableRule::class,
            TableExistsRule::class,
            ArrayRule::class,
            BooleanRule::class,
            DateRule::class,
            EmailRule::class,
            EnumRule::class,
            FileRule::class,
            ImageRule::class,
            PasswordRule::class,
            StringRule::class,
            IntegerRule::class,
            UrlRule::class,
            RegexRule::class,
            CurrentPasswordRule::class,
        ]);
    }
}
