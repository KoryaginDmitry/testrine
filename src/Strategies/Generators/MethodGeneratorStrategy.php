<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Generators;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Data\OpenApi\Path\Method\Method;

class MethodGeneratorStrategy extends BaseGeneratorStrategy
{
    public function generate(OpenApi $data, array $fileData): OpenApi
    {
        if (isset($data->paths[$fileData['path']]->methods[$fileData['method']])) {
            return $data;
        }

        $data->paths[$fileData['path']]->methods[$fileData['method']] = new Method;

        return $data;
    }
}
