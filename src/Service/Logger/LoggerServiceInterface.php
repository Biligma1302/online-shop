<?php

namespace Service\Logger;

interface LoggerServiceInterface
{
    public static function error(\Throwable $exception): void;
}