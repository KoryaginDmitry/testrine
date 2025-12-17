<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Mappers;

use Dkdev\Testrine\Data\OpenApi\OpenApi;

class SummaryMapper extends BaseMapper
{
    public function defaultHandler(): OpenApi
    {
        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->summary = $this->fileData['summary'];

        return $this->data;
    }
}
