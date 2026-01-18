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
use DkDev\Testrine\RequestPayload\Rules\BooleanRule;
use DkDev\Testrine\RequestPayload\Rules\CurrentPasswordRule;
use DkDev\Testrine\RequestPayload\Rules\DateRule;
use DkDev\Testrine\RequestPayload\Rules\EmailRule;
use DkDev\Testrine\RequestPayload\Rules\EnumRule;
use DkDev\Testrine\RequestPayload\Rules\FileRule;
use DkDev\Testrine\RequestPayload\Rules\ImageRule;
use DkDev\Testrine\RequestPayload\Rules\IntegerRule;
use DkDev\Testrine\RequestPayload\Rules\IpRule;
use DkDev\Testrine\RequestPayload\Rules\PasswordRule;
use DkDev\Testrine\RequestPayload\Rules\RegexRule;
use DkDev\Testrine\RequestPayload\Rules\StringRule;
use DkDev\Testrine\RequestPayload\Rules\TableExistsRule;
use DkDev\Testrine\RequestPayload\Rules\UrlRule;
use DkDev\Testrine\Support\Infrastructure\Config;
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
            TableExistsRule::class,
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
            IpRule::class,
        ]);
    }
}
