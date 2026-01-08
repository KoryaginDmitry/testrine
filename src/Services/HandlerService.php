<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

use Closure;
use DkDev\Testrine\EventHandlers\AfterDestroyFilesEventHandler;
use DkDev\Testrine\EventHandlers\AfterDocGenerationEventHandler;
use DkDev\Testrine\EventHandlers\AfterTestEventHandler;
use DkDev\Testrine\EventHandlers\BeforeDestroyFilesEventHandler;
use DkDev\Testrine\EventHandlers\BeforeDocGenerationEventHandler;
use DkDev\Testrine\EventHandlers\BeforeTestsEventHandler;
use DkDev\Testrine\Traits\HasHandler;

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
        AfterDestroyFilesEventHandler::setHandler($closure);
    }

    public function beforeDestroy(Closure $closure): void
    {
        BeforeDestroyFilesEventHandler::setHandler($closure);
    }

    public function afterGeneration(Closure $closure): void
    {
        AfterDocGenerationEventHandler::setHandler($closure);
    }

    public function beforeGeneration(Closure $closure): void
    {
        BeforeDocGenerationEventHandler::setHandler($closure);
    }

    public function afterTests(Closure $closure): void
    {
        AfterTestEventHandler::setHandler($closure);
    }

    public function beforeTests(Closure $closure): void
    {
        BeforeTestsEventHandler::setHandler($closure);
    }
}
