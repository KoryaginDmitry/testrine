<?php

declare(strict_types=1);

namespace DkDev\Testrine\Processors;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Doc\OpenApi\Path\Method\Method;

class MethodProcessor extends BaseProcessor
{
    public function defaultHandler(): BaseDoc
    {
        if (isset($this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']])) {
            return $this->data;
        }

        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']] = new Method;

        return $this->data;
    }
}
