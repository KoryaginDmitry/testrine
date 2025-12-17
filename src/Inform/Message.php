<?php

declare(strict_types=1);

namespace DkDev\Testrine\Inform;

use DkDev\Testrine\Enums\Inform\Level;
use DkDev\Testrine\Traits\Makeable;

/**
 * @method static Message make(Level $level, string $message, bool $prependIndent = false, bool $appendIndent = false)
 */
class Message
{
    use Makeable;

    public function __construct(
        public Level $level,
        public string $message,
        public ?string $icon = null,
        public bool $prependIndent = false,
        public bool $appendIndent = false,
    ) {
        $this->setIcon();
    }

    public function setIcon(): void
    {
        if ($this->icon) {
            return;
        }

        $this->icon = match ($this->level) {
            Level::INFO => '✔ ',
            Level::WARNING => '⚠ ',
            Level::ERROR => '✖ ',
        };
    }
}
