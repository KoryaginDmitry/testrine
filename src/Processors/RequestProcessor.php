<?php

declare(strict_types=1);

namespace DkDev\Testrine\Processors;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Doc\OpenApi\Path\Method\Body\RequestBody;
use DkDev\Testrine\Doc\OpenApi\Path\Method\Parameter\Parameter;
use DkDev\Testrine\Enums\Attributes\In;
use DkDev\Testrine\Support\Builders\SchemeBuilder;

class RequestProcessor extends BaseProcessor
{
    public function defaultHandler(): BaseDoc
    {
        if ($this->hasRequest() || ! $this->isOk()) {
            return $this->data;
        }

        $requestData = collect($this->fileData['request'] ?? [])->where('in', In::BODY->value)->toArray();

        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->requestBody = new RequestBody(
            scheme: SchemeBuilder::makeScheme($requestData),
            contentType: $this->fileData['content_type']['request'] ?? 'application/json',
        );

        $parameters = collect($this->fileData['request'] ?? [])->where('in', '!=', In::BODY->value)->toArray();

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

    protected function hasRequest(): bool
    {
        return isset($this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->requestBody);
    }

    protected function isOk(): bool
    {
        $code = $this->fileData['code']['code'];

        return $code >= 200 && $code < 300;
    }
}
