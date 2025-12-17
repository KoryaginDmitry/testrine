<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Mappers;

use Dkdev\Testrine\Data\OpenApi\OpenApi;
use Dkdev\Testrine\Data\OpenApi\Path\Method\Body\RequestBody;
use Dkdev\Testrine\Data\OpenApi\Path\Method\Parameter\Parameter;
use Dkdev\Testrine\Enums\Attributes\In;
use Dkdev\Testrine\Support\Builders\SchemeBuilder;

class RequestMapper extends BaseMapper
{
    public function defaultHandler(): OpenApi
    {
        if ($this->hasRequest($this->data, $this->fileData) || ! $this->isOk($this->fileData['code']['code'])) {
            return $this->data;
        }

        $requestData = collect($this->fileData['request'] ?? [])->where('in', In::BODY->value)->toArray();

        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->requestBody = new RequestBody(
            scheme: SchemeBuilder::makeScheme($requestData),
            contentType: $fileData['content_type']['request'] ?? 'application/json',
        );

        $parameters = collect($fileData['request'] ?? [])->where('in', '!=', In::BODY->value)->toArray();

        foreach ($parameters as $parameter) {
            $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->parameters[] = new Parameter(
                name: $parameter['name'],
                in: $parameter['in'],
                description: $parameter['description'] ?? null,
                required: $parameter['required'],
                type: $parameter['type'],
                value: $parameter['example'],
            );
        }

        return $this->data;
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
