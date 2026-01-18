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
    public function setHandler(string $handlerClass, Closure $handler): self
    {
        $handlerClass::setHandler(callback: $handler);

        return $this;
    }

    public function afterDestroy(Closure $closure): self
    {
        AfterDestroyFilesEventHandler::setHandler($closure);

        return $this;
    }

    public function beforeDestroy(Closure $closure): self
    {
        BeforeDestroyFilesEventHandler::setHandler($closure);

        return $this;
    }

    public function afterGeneration(Closure $closure): self
    {
        AfterDocGenerationEventHandler::setHandler($closure);

        return $this;
    }

    public function beforeGeneration(Closure $closure): self
    {
        BeforeDocGenerationEventHandler::setHandler($closure);

        return $this;
    }

    public function afterTests(Closure $closure): self
    {
        AfterTestEventHandler::setHandler($closure);

        return $this;
    }

    public function beforeTests(Closure $closure): self
    {
        BeforeTestsEventHandler::setHandler($closure);

        return $this;
    }
}
