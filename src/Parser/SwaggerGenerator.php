<?php

namespace Dkdev\Testrine\Parser;

use Dkdev\Testrine\Data\OpenApi\OpenApi;
use Dkdev\Testrine\Enums\Writes\Format;
use Dkdev\Testrine\Factories\DocFactory;
use Dkdev\Testrine\Factories\ReaderFactory;
use Dkdev\Testrine\Factories\WriterFactory;
use Dkdev\Testrine\Mappers\BaseMapper;
use Dkdev\Testrine\Support\Infrastructure\Config;
use Dkdev\Testrine\Support\Infrastructure\StorageHelper;

class SwaggerGenerator
{
    public function generate(): void
    {
        $doc = DocFactory::build();

        $driver = StorageHelper::driver();

        foreach ($driver->files(Config::getSwaggerValue('storage.data.path')) as $file) {
            $doc = $this->parseFile($doc, $file);
        }

        $this->makeDocs($doc);
    }

    protected function parseFile(OpenApi $doc, string $path): OpenApi
    {
        /** @var BaseMapper $mapper */
        foreach (Config::getSwaggerValue('mappers') as $mapper) {
            $doc = $mapper::make(
                data: $doc,
                fileData: ReaderFactory::make(Format::JSON)->read($path),
            )->handle();
        }

        return $doc;
    }

    protected function makeDocs(OpenApi $data): void
    {
        WriterFactory::make(Format::JSON)->write(
            path: Config::getSwaggerValue('storage.docs.path'),
            name: Config::getSwaggerValue('storage.docs.name'),
            data: (array) $data,
        );
    }
}
