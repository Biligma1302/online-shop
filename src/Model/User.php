<?php

declare(strict_types=1);

namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function getByEmail(string $email): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM  {$tableName} WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $obj = new self();
        $obj->id = $result["id"];
        $obj->name = $result["name"];
        $obj->email = $result["email"];
        $obj->password = $result["password"];

        return $obj;
    }

    public static function updateEmailById(string $email, int $user_id): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE {$tableName}  SET email = :email WHERE id = :user_id");
        $stmt->execute([':email' => $email, ':user_id' => $user_id]);
    }

    public static function updateNameById(string $name, int $user_id): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE {$tableName}  SET name = :name WHERE id = :user_id");
        $stmt->execute([':name' => $name, ':user_id' => $user_id]);
    }

    public static function getById(int $user_id): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }
        $obj = new self();
        $obj->id = $result["id"];
        $obj->name = $result["name"];
        $obj->email = $result["email"];
        $obj->password = $result["password"];

        return $obj;
    }

    public static function insertInto(string $name, string $email, string $hashedPassword): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (name, email, password) VALUES (:name, :email, :hashedPassword)"
        );
        $stmt->execute(['name' => $name, 'email' => $email, 'hashedPassword' => $hashedPassword]);
    }

    public static function getByUsername(string $username): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName}  WHERE email = :email");
        $stmt->execute([':email' => $username]);
        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user["id"];
        $obj->name = $user["name"];
        $obj->email = $user["email"];
        $obj->password = $user["password"];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}