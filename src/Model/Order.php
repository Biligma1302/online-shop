<?php

namespace Model;
class Order extends Model
{
    private int $id;
    private int $user_id;
    private string $contact_name;
    private string $contact_phone;
    private string $comment;
    private string $address;

   protected function getTableName(): string
   {
       return 'orders';
   }



    public function create(string $contactName, string $contactPhone, string $comment, string $address, int $user_id)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()} (contact_name, contact_phone, comment, address, user_id) 
                   VALUES (:contact_name, :contact_phone, :comment, :address, :user_id) RETURNING id");

        $stmt->execute([
            'contact_name' => $contactName,
            'contact_phone' => $contactPhone,
            'comment' => $comment,
            'address' => $address,
            'user_id' => $user_id
        ]);
        $data = $stmt->fetch();
        return $data['id'];


    }

    public function getAllByUserId(int $user_id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()}  WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $userOrders = $stmt->fetchAll();

        $orders = [];

        foreach ($userOrders as $userOrder) {
            $obj = new self();
            $obj->id = $userOrder["id"];
            $obj->user_id = $userOrder['user_id'];
            $obj->contact_name = $userOrder['contact_name'];
            $obj->contact_phone = $userOrder['contact_phone'];
            $obj->comment = $userOrder['comment'];
            $obj->address = $userOrder['address'];
            $orders[] = $obj;
        }

        return $orders;
    }
        public function getUserId(): int
        {
            return $this->user_id;
        }

        public function getContactName(): string
        {
            return $this->contact_name;
        }

        public function getContactPhone(): string
        {
            return $this->contact_phone;
        }

        public function getComment(): string
        {
            return $this->comment;
        }

        public function getAddress(): string
        {
            return $this->address;
        }

        public function getId(): int
        {
            return $this->id;
        }

}



