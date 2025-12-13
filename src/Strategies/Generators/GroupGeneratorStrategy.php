<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Generators;

use DkDev\Testrine\Data\OpenApi\OpenApi;

class GroupGeneratorStrategy extends BaseGeneratorStrategy
{
    public function generate(OpenApi $data, array $fileData): OpenApi
    {
        $data->paths[$fileData['path']]->methods[$fileData['method']]->tags = [
            $fileData['group'],
        ];

        return $data;
    }
}
