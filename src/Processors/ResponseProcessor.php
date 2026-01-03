<?php

declare(strict_types=1);

namespace DkDev\Testrine\Processors;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Doc\OpenApi\Path\Method\Response\Code;
use DkDev\Testrine\Support\Builders\SchemeBuilder;

class ResponseProcessor extends BaseProcessor
{
    public function defaultHandler(): BaseDoc
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
