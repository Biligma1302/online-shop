<?php

namespace Model;
class Order extends Model
{

    public function create(string $contactName, string $contactPhone, string $comment, $address, int $user_id){
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (contact_name, contact_phone, comment, address, user_id) 
                   VALUES (:contact_name, :contact_phone, :comment, :address, :user_id) RETURNING id");

        $stmt -> execute([
            'contact_name'=>$contactName,
            'contact_phone'=>$contactPhone,
            'comment'=> $comment,
            'address'=>$address,
            'user_id'=>$user_id
        ]);
        $data = $stmt->fetch();
        return $data['id'];
    }
    public function getAllByUserId(int $user_id) {
       $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
       $stmt->execute(['user_id' => $user_id]);
       $userOrders = $stmt->fetchAll();
       return $userOrders;



    }
}