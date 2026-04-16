<?php
namespace Model;
class UserProduct extends Model
{
 private int $id;
 private int $product_id;
 private int $user_id;
 private int $amount;

    protected function getTableName(): string
    {
        return 'user_products';
    }


    public function getAllUserProductsByUserId(int $user_id):array|false
    {

        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE user_id = {$user_id}");
        $userProducts = $stmt->fetchAll();
        $user_products = [];
        foreach ($userProducts as $userProduct) {
            $obj = new self();

            $obj->id = $userProduct["id"];
            $obj->product_id = $userProduct["product_id"];
            $obj->amount = $userProduct["amount"];
            $obj->user_id = $userProduct["user_id"];
            $user_products[] = $obj;
        }
        return $user_products;
    }



    public function deleteByUserId (int $user_id)
    {
   $stmt = $this->pdo->prepare ("DELETE FROM  {$this->getTableName()} WHERE user_id = :user_id");
   $stmt->execute([':user_id' => $user_id]);

    }
    public function getUserProduct(int $product_id, int $user_id):self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $data = $stmt->fetch();
        if($data===false){
            return null;
        }
        $obj = new self;
        $obj->id= $data['id'];
        $obj->user_id = $data['user_id'];
        $obj->product_id = $data['product_id'];
        $obj->amount = $data['amount'];

        return $obj;
    }
    public function insertUserProduct(int $user_id, int $product_id, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function updateUserProduct(int $amount, int $user_id, int $product_id)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET amount = :amount WHERE user_id = :user_id and product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $user_id, 'product_id' => $product_id]);
    }

    public function deleteUserProducts(int $user_id, int $product_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :user_id and product_id = :product_id");
       return $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);

    }
    public function getAmountCartItems($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        $user_products = [];
          foreach ($data as $product) {
            $obj = new self();
            $obj->amount = $product['amount'];
            $user_products[$product['product_id']] = $obj;

        }
        return $user_products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}




