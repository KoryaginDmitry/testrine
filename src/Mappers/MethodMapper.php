<?php

declare(strict_types=1);

namespace DkDev\Testrine\Mappers;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Data\OpenApi\Path\Method\Method;

class MethodMapper extends BaseMapper
{
    public function defaultHandler(): OpenApi
    {
        if (isset($this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']])) {
            return $this->data;
        }

        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']] = new Method;

        return $this->data;
    }
}
