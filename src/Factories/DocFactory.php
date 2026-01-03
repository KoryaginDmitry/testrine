<?php

declare(strict_types=1);

namespace DkDev\Testrine\Factories;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Support\Infrastructure\Config;

class DocFactory
{
    public static function build(): BaseDoc
    {
        $authSchemeName = Config::getDocsValue('auth.security_scheme');
        $authScheme = Config::getDocsValue('auth.security_schemes')[$authSchemeName];

        $data = [
            'openapi' => Config::getDocsValue('openapi'),
            'info' => Config::getDocsValue('info'),
            'servers' => Config::getDocsValue('servers'),
            'paths' => [],
            'components' => [
                'securitySchemes' => [
                    $authSchemeName => $authScheme,
                ],
            ],
        ];

        /** @var class-string<BaseDoc> $class */
        $class = Config::getDocsValue('dto');

        return $class::fromArray($data);
    }
}
