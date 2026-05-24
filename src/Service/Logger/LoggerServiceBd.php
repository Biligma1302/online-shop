<?php

declare(strict_types=1);

namespace Service\Logger;

use Model\Error;

class LoggerServiceBd implements LoggerServiceInterface
{
    public static function error(\Throwable $exception): void
    {
        $errorModel = new Error();
        $errorModel->create
        (
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
        );
    }
}