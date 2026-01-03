<?php

declare(strict_types=1);

namespace DkDev\Testrine\Processors;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Support\Infrastructure\Config;

class AuthProcessor extends BaseProcessor
{
    public function defaultHandler(): BaseDoc
    {
        if ($this->fileData['auth']) {
            $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->security = [
                [
                    Config::getDocsValue('auth.security_scheme') => [],
                ],
            ];
        }

        return $this->data;
    }
}
