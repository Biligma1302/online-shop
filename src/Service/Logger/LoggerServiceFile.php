<?php

namespace Service\Logger;

class LoggerServiceFile implements LoggerServiceInterface
{
    public static function error(\Throwable $exception): void
    {
        $log = "Message:" . $exception->getMessage() . "\n" .
            "File:" . $exception->getFile() . "\n" .
            "Line:" . $exception->getLine() . "\n" .
            "Date" . date('d.m.Y H:i:s') . "\n" .
            "\n\n";

        $path = dirname(__DIR__, 2) . '/Storage/Log/errors.txt';

        file_put_contents($path, $log, FILE_APPEND);
    }
}