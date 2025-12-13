<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Generators;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Data\OpenApi\Path\Method\Response\Code;
use DkDev\Testrine\Helpers\SchemeBuilder;

class ResponseGeneratorStrategy extends BaseGeneratorStrategy
{
    public function generate(OpenApi $data, array $fileData): OpenApi
    {
        if (isset($data->paths[$fileData['path']]->methods[$fileData['method']]->responses[$fileData['code']['code']])) {
            return $data;
        }

        $code = new Code(
            description: $fileData['code']['description'] ?? '',
            scheme: SchemeBuilder::makeScheme($fileData['response']),
            contentType: $fileData['content_type']['response'] ?? 'application/json',
        );

        $data->paths[$fileData['path']]->methods[$fileData['method']]->responses[$fileData['code']['code']] = $code;

        return $data;
    }
}
