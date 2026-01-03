<?php

declare(strict_types=1);

namespace DkDev\Testrine\Processors;

use DkDev\Testrine\Doc\BaseDoc;

class SummaryProcessor extends BaseProcessor
{
    public function defaultHandler(): BaseDoc
    {
        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->summary = $this->fileData['summary'];

        return $this->data;
    }
}
