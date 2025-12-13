<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Generators;

use DkDev\Testrine\Data\OpenApi\OpenApi;

class SummaryGeneratorStrategy extends BaseGeneratorStrategy
{
    public function generate(OpenApi $data, array $fileData): OpenApi
    {
        $data->paths[$fileData['path']]->methods[$fileData['method']]->summary = $fileData['summary'];

        return $data;
    }
}
