<?php

declare(strict_types=1);

namespace DkDev\Testrine\Processors;

use DkDev\Testrine\Doc\BaseDoc;

class DescriptionProcessor extends BaseProcessor
{
    public function defaultHandler(): BaseDoc
    {
        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->description = $this->fileData['description'] ?? '';

        return $this->data;
    }
}
