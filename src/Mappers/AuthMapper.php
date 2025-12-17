<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Mappers;

use Dkdev\Testrine\Data\OpenApi\OpenApi;
use Dkdev\Testrine\Support\Infrastructure\Config;

class AuthMapper extends BaseMapper
{
    public function defaultHandler(): OpenApi
    {
        if ($this->fileData['auth']) {
            $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->security = [
                [
                    Config::getSwaggerValue('auth.security_scheme') => [],
                ],
            ];
        }

        return $this->data;
    }
}
