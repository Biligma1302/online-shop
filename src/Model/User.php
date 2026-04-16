<?php
namespace Model;
class User extends Model
{
   private int $id;
   private string $name;
   private string $email;
   private string $password;

    protected function getTableName(): string
    {
        return 'users';
    }


    public function getByEmail(string $email): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM  {$this->getTableName()} WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();
        if ($result===false){
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

        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} ( SET email = :email WHERE id = $user_id");
        $stmt->execute([':email' => $email]);
    }

    public function updateNameById(string $name, int $user_id)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} ( SET name = :name WHERE id = $user_id");
        $stmt->execute([':name' => $name]);
    }

    public function getById(int $user_id): self|null
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE id = $user_id");
        $result = $stmt->fetch();

        if ($result===false){
            return null;
        }
        $obj = new self();
        $obj->id = $result["id"];
        $obj->name = $result["name"];
        $obj->email = $result["email"];
        $obj->password = $result["password"];

        return $obj;
    }

    public function insertInto(string $name, string $email, string $hashedPassword)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (name, email, password) VALUES (:name, :email, :hashedPassword)");
        $stmt->execute(['name' => $name, 'email' => $email, 'hashedPassword' => $hashedPassword]);

    }

    public function getByUsername(string $username):self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()}  WHERE email = :email");
        $stmt->execute([':email' => $username]);
        $user = $stmt->fetch();

        if ($user=== false){
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

