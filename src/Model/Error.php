<?php

namespace Model;

class Error extends Model{

    protected function getTableName(): string
    {
        return 'errors';
    }

    public function create(string $message, string $file, int $line): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()} (message, file, line, created_at) 
                   VALUES (:message, :file, :line, :created_at)");
       return $stmt->execute([
           'message' => $message,
            'file' => $file,
            'line' => $line,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}


