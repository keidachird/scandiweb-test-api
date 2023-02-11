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

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    // Create a product
    public function create(array $data): string
    {
        $sql = "INSERT INTO products (sku, name, price, type, weight, size, height, width, length)
                VALUES (:sku, :name, :price, :type, :weight, :size, :height, :width, :length)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":sku", $data["sku"]);
        $stmt->bindValue(":name", $data["name"]);
        $stmt->bindValue(":price", $data["price"]);
        $stmt->bindValue(":type", $data["type"]);
        $stmt->bindValue(":weight", $data["weight"] ?? null);
        $stmt->bindValue(":size", $data["size"] ?? null);
        $stmt->bindValue(":height", $data["height"] ?? null);
        $stmt->bindValue(":width", $data["width"] ?? null);
        $stmt->bindValue(":length", $data["length"] ?? null);

        $stmt->execute();

        return $data["sku"];
    }

    // Mass delete based on list of sku
    public function massDelete(array $data): void
    {
        foreach ($data as $sku) {
            $sql = "DELETE FROM products
                    WHERE sku=:sku";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":sku", $sku);

            $stmt->execute();
        }
    }

    // Checks if sku is unique
    public function checkUniqueSku(string $sku): bool
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