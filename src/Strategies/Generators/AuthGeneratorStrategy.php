<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Generators;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Helpers\Config;

class AuthGeneratorStrategy extends BaseGeneratorStrategy
{
    public function generate(OpenApi $data, array $fileData): OpenApi
    {
        if ($fileData['auth']) {
            $data->paths[$fileData['path']]->methods[$fileData['method']]->security = [
                [
                    Config::getSwaggerValue('auth.security_scheme') => [],
                ],
            ];
        }

        return $data;
    }
}
