<?php

declare(strict_types=1);

namespace DkDev\Testrine\Factories;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Support\Infrastructure\Config;

class DocFactory
{
    public static function build(): OpenApi
    {
        $authSchemeName = Config::getSwaggerValue('auth.security_scheme');
        $authScheme = Config::getSwaggerValue('auth.security_schemes')[$authSchemeName];

        $data = [
            'openapi' => Config::getSwaggerValue('openapi'),
            'info' => Config::getSwaggerValue('info'),
            'servers' => Config::getSwaggerValue('servers'),
            'paths' => [],
            'components' => [
                'securitySchemes' => [
                    $authSchemeName => $authScheme,
                ],
            ],
        ];

        return OpenApi::fromArray($data);
    }
}
