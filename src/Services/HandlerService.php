<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Services;

use Dkdev\Testrine\Handlers\AfterDestroyFilesHandler;
use Dkdev\Testrine\Handlers\AfterDocGenerationHandler;
use Dkdev\Testrine\Handlers\AfterTestHandler;
use Dkdev\Testrine\Handlers\BeforeDestroyFilesHandler;
use Dkdev\Testrine\Handlers\BeforeDocGenerationHandler;
use Dkdev\Testrine\Handlers\BeforeTestsHandler;
use Dkdev\Testrine\Traits\HasHandler;

class HandlerService extends BaseService
{
    /**
     * @param  class-string<HasHandler>  $handlerClass
     */
    public static function setHandler(string $handlerClass, Closure $handler): void
    {
        $handlerClass::setHandler(callback: $handler);
    }

    public function afterDestroy(Closure $closure): void
    {
        AfterDestroyFilesHandler::setHandler($closure);
    }

    public function beforeDestroy(Closure $closure): void
    {
        BeforeDestroyFilesHandler::setHandler($closure);
    }

    public function afterGeneration(Closure $closure): void
    {
        AfterDocGenerationHandler::setHandler($closure);
    }

    public function beforeGeneration(Closure $closure): void
    {
        BeforeDocGenerationHandler::setHandler($closure);
    }

    public function afterTests(Closure $closure): void
    {
        AfterTestHandler::setHandler($closure);
    }

    public function beforeTests(Closure $closure): void
    {
        BeforeTestsHandler::setHandler($closure);
    }
}
