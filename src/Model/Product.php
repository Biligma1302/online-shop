<?php
namespace Model;
class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image_url;

    protected function getTableName(): string
    {
        return 'products';
    }


    public function getProducts()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()}");

        $products = $stmt->fetchAll();
        $result = [];

        foreach ($products as $product)
        {
            $obj = new self();

            $obj->id = $product['id'];
            $obj->name = $product['name'];
            $obj->description = $product['description'];
            $obj->price = $product['price'];
            $obj->image_url = $product['image_url'];

            $result[] = $obj;
        }
        return $result;
    }

    public function getById(int $product_id): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $product = $stmt->fetch();

        if($product === false) {
            return null;
        }
        $obj = new self;
        $obj->id = $product['id'];
        $obj->name = $product['name'];
        $obj->description = $product['description'];
        $obj->price = $product['price'];
        $obj->image_url = $product['image_url'];

        return $obj;
    }
    public function getFull($userProducts): array
    {
        $products = [];

        foreach ($userProducts as $userProduct) {

            $product = $this->getById($userProduct->getProductId());

            if ($product === null) {
                continue;
            }
            $products[] = [
                'amount'    => $userProduct->getAmount(),
                'name'      => $product->getName(),
                'price'     => $product->getPrice(),
                'image'     => $product->getImageUrl(),
                'productId' => $product->getId(),
            ];
        }

        return $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }




}