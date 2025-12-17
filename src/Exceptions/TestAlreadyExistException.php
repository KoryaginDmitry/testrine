<?php

declare(strict_types=1);

namespace DkDev\Testrine\Exceptions;

use Exception;

class TestAlreadyExistException extends Exception
{
    public string $path;

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }
}
