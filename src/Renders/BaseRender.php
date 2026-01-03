<?php

declare(strict_types=1);

namespace DkDev\Testrine\Renders;

abstract class BaseRender
{
    abstract public function render(): mixed;
}
