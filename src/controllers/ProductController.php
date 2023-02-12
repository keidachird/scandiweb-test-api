<?php

readonly class ProductController
{
    public function __construct(private ProductGateway $gateway)
    {
    }

    public function processRequest(string $method, array $uri_parts): void
    {
        // Check if uri has wrong format
        if ($uri_parts[1] !== "" && $uri_parts[1] !== "add-product" || sizeof($uri_parts) > 2) {
            http_response_code(404);
            return;
        }

        switch ($method) {
            // localhost/
            // Process "GET" request
            // Returns a list of products info
            case "GET":
                // Checks if uri is correct for GET request
                if ($uri_parts[1] === "add-product") {
                    http_response_code(405);
                    header("Access-Control-Allow-Methods: POST");
                    break;
                }
                $data = $this->gateway->getAll();

                $result = [];
                foreach ($data as $row) {
                    $type = $row["type"];

                    $product = null;
                    switch ($type) {
                        case "book":
                            $product = new ProductBook($row);
                            break;
                        case "dvd":
                            $product = new ProductDvd($row);
                            break;
                        case "furniture":
                            $product = new ProductFurniture($row);
                            break;
                    }

                    $result[] = $product->getInfo();
                }
                echo json_encode($result);
                break;

            // localhost/add-product
            // Process "POST" request
            // Create a new product
            case "POST":
                // Checks if uri is correct for POST request
                if ($uri_parts[1] === "") {
                    http_response_code(405);
                    header("Access-Control-Allow-Methods: GET, DELETE");
                    break;
                }

                // Get product data
                $data = (array)json_decode(file_get_contents("php://input"), true);

                // Product data validation
                $errors = $this->getValidationErrors($data);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                // Create new product object
                $product = null;
                switch ($data["type"]) {
                    case "book":
                        $product = new ProductBook($data);
                        break;
                    case "dvd":
                        $product = new ProductDvd($data);
                        break;
                    case "furniture":
                        $product = new ProductFurniture($data);
                        break;
                }

                // Add new product row in db
                $sku = $this->gateway->create($product->getInfo());

                http_response_code(201);
                echo json_encode([
                    "message" => "Product created",
                    "sku" => $sku
                ]);
                break;

            // localhost/
            // Process "DELETE" request
            // Mass delete products
            case "DELETE":
                // Get array of sku needed to delete
                $data = (array)json_decode(file_get_contents("php://input"), true);

                // There is no validation for sku
                // If sku doesn't exist - just ignore it

                // Delete rows in db with specified sku
                $this->gateway->massDelete($data["skuList"]);

                http_response_code(200);
                echo json_encode([
                    "data" => $data
                ]);
                break;
        }
    }

    // Get array of validation errors
    private function getValidationErrors(array $data): array
    {
        $errors = [];

        // Check for empty inputs
        empty($data["sku"]) && $errors[] = "sku is required";
        empty($data["name"]) && $errors[] = "name is required";
        empty($data["price"]) && $errors[] = "price is required";
        empty($data["type"]) && $errors[] = "type is required";

        // Check for corresponding properties for each type of product
        switch ($data["type"]) {
            case "book":
                empty($data["weight"]) && $errors[] = "weight is required for type book";
                break;
            case "dvd":
                empty($data["size"]) && $errors[] = "size is required for type dvd";
                break;
            case "furniture":
                empty($data["height"]) && $errors[] = "height is required for type furniture";
                empty($data["width"]) && $errors[] = "width is required for type furniture";
                empty($data["length"]) && $errors[] = "length is required for type furniture";
                break;
            default:
                $errors[] = "wrong type of product";
        }

        // Check for unique sku
        $isUnique = $this->gateway->checkUniqueSku($data["sku"]);
        $isUnique || $errors[] = "sku must be unique";

        return $errors;
    }
}