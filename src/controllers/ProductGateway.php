<?php

class ProductGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    // Get array of products
    public function getAll(): array
    {
        $sql = "SELECT *
                FROM products
                ORDER BY sku";

        $stmt = $this->conn->query($sql);

        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            switch ($row["type"]) {
                case "dvd":
                    $products[] = new ProductDvd($row);
                    break;
                case "book":
                    $products[] = new ProductBook($row);
                    break;
                case "furniture":
                    $products[] = new ProductFurniture($row);
                    break;
            }
        }

        return $products;
    }

    // Create a product
    public function create(Product $product): string
    {
        $sql = "INSERT INTO products (sku, name, price, type, attribute)
                VALUES (:sku, :name, :price, :type, :attribute)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":sku", $product->getSku());
        $stmt->bindValue(":name", $product->getName());
        $stmt->bindValue(":price", $product->getPrice());
        $stmt->bindValue(":type", $product->getType());
        $stmt->bindValue(":attribute", $product->getAttribute());

        $stmt->execute();

        return $product->getSku();
    }

    // Mass delete based on list of sku
    public function massDelete(array $skuList): void
    {
        foreach ($skuList as $sku) {
            $sql = "DELETE FROM products
                    WHERE sku=:sku";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":sku", $sku);

            $stmt->execute();
        }
    }

    // Checks if sku is unique
    public function isUniqueSku(string $sku): bool
    {
        $sql = "SELECT * 
                FROM products
                WHERE sku=:sku";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":sku", $sku);

        $stmt->execute();

        return !$stmt->fetch(PDO::FETCH_ASSOC);
    }
}