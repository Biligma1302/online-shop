<?php
namespace Model;
class User extends Model
{
   private int $id;
   private string $name;
   private string $email;
   private string $password;

    public function getByEmail(string $email): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $result = $stmt->fetch();
        if ($result=== false){
            return null;
        }

        $obj = new self();
        $obj->id = $result["id"];
        $obj->name = $result["name"];
        $obj->email = $result["email"];
        $obj->password = $result["password"];

        return $obj;
    }

    public function updateEmailById(string $email, int $user_id)
    {

        $stmt = $this->pdo->prepare("UPDATE users SET email = :email WHERE id = $user_id");
        $stmt->execute([':email' => $email]);
    }

    public function updateNameById(string $name, int $user_id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name WHERE id = $user_id");
        $stmt->execute([':name' => $name]);
    }

    public function getById(int $user_id): array
    {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE id = $user_id");
        $result = $stmt->fetch();
        return $result;
    }

    public function insertInto(string $name, string $email, string $hashedPassword)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :hashedPassword)");
        $stmt->execute(['name' => $name, 'email' => $email, 'hashedPassword' => $hashedPassword]);

    }

    public function getByUsername(string $username): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $username]);
        $user = $stmt->fetch();
        return $user;
    }
}

