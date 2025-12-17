<?php

declare(strict_types=1);

namespace DkDev\Testrine\Mappers;

use DkDev\Testrine\Data\OpenApi\Path\Method\Response\Code;
use DkDev\Testrine\Support\Builders\SchemeBuilder;

class ResponseMapper extends BaseMapper
{
    public function defaultHandler(): mixed
    {
        if (isset($this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->responses[$this->fileData['code']['code']])) {
            return $this->data;
        }

        $code = new Code(
            description: $this->fileData['code']['description'] ?? '',
            scheme: SchemeBuilder::makeScheme($this->fileData['response']),
            contentType: $this->fileData['content_type']['response'] ?? 'application/json',
        );

        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->responses[$this->fileData['code']['code']] = $code;

        return $this->data;
    }
}
