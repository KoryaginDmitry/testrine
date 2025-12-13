<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Generators;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Strategies\BaseStrategy;

abstract class BaseGeneratorStrategy extends BaseStrategy
{
    abstract public function generate(OpenApi $data, array $fileData);
}
