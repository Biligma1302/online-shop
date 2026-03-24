<?php
namespace Model;
class Cart extends Model
{

    public function getUserCart(int $user_id)
    {

        $stmt = $this->pdo->query("SELECT * FROM user_products WHERE user_id = {$user_id}");
        $userProducts = $stmt->fetchAll();
        return $userProducts;
    }

    public function getFull($userProducts)
    {
        $products = [];

        foreach ($userProducts as $userProduct) {

            $product_id = $userProduct['product_id'];
            $stmt = $this->pdo->query("SELECT * FROM products WHERE id = $product_id");
            $product = $stmt->fetch();

            $product['amount'] = $userProduct['amount'];

            $products[] = $product;
        }
        return $products;
    }

    public function deleteByUserId (int $user_id)
    {
   $stmt = $this->pdo->prepare ("DELETE FROM user_products WHERE user_id = :user_id");
   $stmt->execute([':user_id' => $user_id]);

    }
}




