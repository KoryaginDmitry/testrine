<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

class ContentTypeCollector extends Collector
{
    public function getName(): string
    {
        return 'content_type';
    }

    public function defaultHandler(): mixed
    {
        return [
            'response' => $this->response->headers->get('Content-Type'),
            'request' => request()->headers->get('Content-Type'),
        ];
    }
}
