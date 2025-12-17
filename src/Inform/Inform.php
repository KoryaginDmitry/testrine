<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Inform;

use Dkdev\Testrine\Enums\Inform\Level;
use Illuminate\Console\Command;

class Inform
{
    /**
     * @var array<Message>
     */
    public static array $messages = [];

    public static function push(
        string $message,
        Level $level = Level::INFO,
        bool $prependIndent = false,
        bool $appendIndent = false
    ): void {
        self::$messages[] = Message::make(
            level: $level,
            message: $message,
            prependIndent: $prependIndent,
            appendIndent: $appendIndent
        );
    }

    public static function list(): array
    {
        return self::$messages;
    }

    public static function clear(): void
    {
        self::$messages = [];
    }

    public static function print(Command $command): void
    {
        foreach (self::$messages as $key => $message) {
            if ($message->prependIndent) {
                $command->newLine();
            }

            match ($message->level) {
                Level::INFO => $command->info($message->icon.$message->message),
                Level::WARNING => $command->warn($message->icon.$message->message),
                Level::ERROR => $command->error($message->icon.$message->message),
            };

            if ($message->appendIndent) {
                $command->newLine();
            }

            unset(self::$messages[$key]);
        }
    }
}
