<?php

declare(strict_types=1);

namespace Model;

class Error extends Model
{

    protected static function getTableName(): string
    {
        return 'errors';
    }

    public static function create(string $message, string $file, int $line): bool
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (message, file, line, created_at) 
                   VALUES (:message, :file, :line, :created_at)"
        );
        return $stmt->execute([
            'message' => $message,
            'file' => $file,
            'line' => $line,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}


