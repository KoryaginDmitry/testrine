<?php

namespace DkDev\Testrine\Parser;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Enums\Writes\Format;
use DkDev\Testrine\Factories\DocFactory;
use DkDev\Testrine\Factories\ReaderFactory;
use DkDev\Testrine\Factories\WriterFactory;
use DkDev\Testrine\Processors\BaseProcessor;
use DkDev\Testrine\Support\Infrastructure\Config;
use DkDev\Testrine\Support\Infrastructure\StorageHelper;

class SwaggerParser
{
    public function generate(): void
    {
        $doc = DocFactory::build();

        foreach (StorageHelper::driver()->files(Config::getDocsValue('storage.data.path')) as $file) {
            $doc = $this->parseFile($doc, $file);
        }

        $this->makeDocs($doc);
    }

    protected function parseFile(BaseDoc $doc, string $path): BaseDoc
    {
        /** @var BaseProcessor $mapper */
        foreach (Config::getDocsValue('processors') as $mapper) {
            $doc = $mapper::make(
                data: $doc,
                fileData: ReaderFactory::make(Format::JSON)->read($path),
            )->handle();
        }

        return $doc;
    }

    protected function makeDocs(BaseDoc $data): void
    {
        WriterFactory::make(Format::JSON)->write(
            path: Config::getDocsValue('storage.docs.path'),
            name: Config::getDocsValue('storage.docs.name'),
            data: (array) $data,
        );
    }
}
