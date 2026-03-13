<?php
class User
{

    private PDO $PDO;
    public function __construct(){
        $this->PDO = new PDO('pgsql:host=postgres_db; port=5432;dbname=dugarovadb', 'dugarova', 'Dugarova1302');
    }
    public function getByEmail(string $email): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $result = $stmt->fetch();

        return $result;
    }

    public function updateEmailById(string $email, int $user_id)
    {

        $stmt = $this->PDO->prepare("UPDATE users SET email = :email WHERE id = $user_id");
        $stmt->execute([':email' => $email]);
    }

    public function updateNameById(string $name, int $user_id)
    {
        $stmt = $this->PDO->prepare("UPDATE users SET name = :name WHERE id = $user_id");
        $stmt->execute([':name' => $name]);
    }

    public function getbyId(int $user_id): array
    {
        $stmt = $this->PDO->query("SELECT * FROM users WHERE id = $user_id");
        $result = $stmt->fetch();
        return $result;
    }

    public function insertInto(string $name, string $email, string $hashedPassword)
    {
        $stmt = $this->PDO->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :hashedPassword)");
        $stmt->execute(['name' => $name, 'email' => $email, 'hashedPassword' => $hashedPassword]);

    }

    public function getByUsername(string $username): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $username]);
        $user = $stmt->fetch();
        return $user;
    }
}

