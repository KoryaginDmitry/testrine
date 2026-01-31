<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

use Illuminate\Http\Testing\File;

class ContentTypeCollector extends Collector
{
    public function getName(): string
    {
        return 'content_type';
    }

    public function defaultHandler(): array
    {
        return [
            'response' => $this->response->headers->get('Content-Type'),
            'request' => $this->requestHasFile() ? 'multipart/form-data' : request()->headers->get('Content-Type'),
        ];
    }

    protected function requestHasFile(): bool
    {
        foreach (request()->all() as $param) {
            if ($param instanceof File) {
                return true;
            }
        }

        return false;
    }
}
