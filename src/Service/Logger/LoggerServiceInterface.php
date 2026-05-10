<?php

namespace Service\Logger;

use Throwable;

interface LoggerServiceInterface
{
    public static function error(Throwable $exception): void;
}