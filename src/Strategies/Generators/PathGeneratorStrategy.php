<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Generators;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Data\OpenApi\Path\Path;

class PathGeneratorStrategy extends BaseGeneratorStrategy
{
    public function generate(OpenApi $data, array $fileData): OpenApi
    {
        if (isset($data->paths[$fileData['path']])) {
            return $data;
        }

        $data->paths[$fileData['path']] = new Path;

        return $data;
    }
}
