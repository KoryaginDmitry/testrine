<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Generators;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Data\OpenApi\Path\Method\Body\RequestBody;
use DkDev\Testrine\Data\OpenApi\Path\Method\Parameter\Parameter;
use DkDev\Testrine\Enums\Attributes\In;
use DkDev\Testrine\Helpers\SchemeBuilder;

class RequestGeneratorStrategy extends BaseGeneratorStrategy
{
    public function generate(OpenApi $data, array $fileData): OpenApi
    {
        if ($this->hasRequest($data, $fileData) || ! $this->isOk($fileData['code']['code'])) {
            return $data;
        }

        $requestData = collect($fileData['request'] ?? [])->where('in', In::BODY->value)->toArray();

        $data->paths[$fileData['path']]->methods[$fileData['method']]->requestBody = new RequestBody(
            scheme: SchemeBuilder::makeScheme($requestData),
            contentType: $fileData['content_type']['request'] ?? 'application/json',
        );

        $parameters = collect($fileData['request'] ?? [])->where('in', '!=', In::BODY->value)->toArray();

        foreach ($parameters as $parameter) {
            $data->paths[$fileData['path']]->methods[$fileData['method']]->parameters[] = new Parameter(
                name: $parameter['name'],
                in: $parameter['in'],
                description: $parameter['description'] ?? null,
                required: $parameter['required'],
                type: $parameter['type'],
                value: $parameter['example'],
            );
        }

        return $data;
    }

    protected function hasRequest(OpenApi $data, array $fileData): bool
    {
        return isset($data->paths[$fileData['path']]->methods[$fileData['method']]->requestBody);
    }

    protected function isOk(string|int $code): bool
    {
        return $code >= 200 && $code < 300;
    }
}
