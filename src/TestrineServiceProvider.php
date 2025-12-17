<?php

namespace Dkdev\Testrine;

use Dkdev\Testrine\Console\DestroyDataCommand;
use Dkdev\Testrine\Console\GenerateCommand;
use Dkdev\Testrine\Console\GenerateTestsCommand;
use Dkdev\Testrine\Console\InitCommand;
use Dkdev\Testrine\Console\MakeCommand;
use Dkdev\Testrine\Console\ParseCommand;
use Dkdev\Testrine\ValidData\Rules\ArrayRule;
use Dkdev\Testrine\ValidData\Rules\BooleanRule;
use Dkdev\Testrine\ValidData\Rules\CurrentPasswordRule;
use Dkdev\Testrine\ValidData\Rules\DateRule;
use Dkdev\Testrine\ValidData\Rules\EmailRule;
use Dkdev\Testrine\ValidData\Rules\EnumRule;
use Dkdev\Testrine\ValidData\Rules\FileRule;
use Dkdev\Testrine\ValidData\Rules\ImageRule;
use Dkdev\Testrine\ValidData\Rules\IntegerRule;
use Dkdev\Testrine\ValidData\Rules\NullableRule;
use Dkdev\Testrine\ValidData\Rules\PasswordRule;
use Dkdev\Testrine\ValidData\Rules\RegexRule;
use Dkdev\Testrine\ValidData\Rules\StringRule;
use Dkdev\Testrine\ValidData\Rules\TableExistsRule;
use Dkdev\Testrine\ValidData\Rules\UrlRule;
use Illuminate\Support\ServiceProvider;

class TestrineServiceProvider extends ServiceProvider
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
