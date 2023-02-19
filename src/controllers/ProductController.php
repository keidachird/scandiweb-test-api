<?php

readonly class ProductController
{
    public function __construct(private ProductGateway $gateway)
    {
    }

    public function processRequest(string $method, array $uri): void
    {
        // Check if uri is valid
        $this->checkUri($method, $uri);

        switch ($method) {
            // Process "GET" request
            // Returns a list of products info
            case "GET":
                // Get array of products
                $products = $this->gateway->getAll();

                // Get info for each product
                $productsInfo = [];
                foreach ($products as $product) {
                    $productsInfo[] = $product->getInfo();
                }
                echo json_encode($productsInfo);
                break;

            // Process "POST" request
            // Create a new product
            case "POST":
                // Get product data from input
                $data = (array)json_decode(file_get_contents("php://input"), true);

                // Product data validation
                $errors = $this->getValidationErrors($data);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                // Check for unique sku
                $isUnique = $this->gateway->isUniqueSku($data["sku"]);
                if (!$isUnique) {
                    http_response_code(409);
                    echo json_encode([
                        "message" => "Product with this sku already exists"
                    ]);
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
                $sku = $this->gateway->create($product);

                http_response_code(201);
                echo json_encode([
                    "message" => "Product created",
                    "sku" => $sku
                ]);
                break;

            // Process "DELETE" request
            // Mass delete products
            case "DELETE":
                // Get array of sku needed to delete
                $data = (array)json_decode(file_get_contents("php://input"), true);

                // There is no validation for sku
                // If sku doesn't exist - just ignores it

                // Delete rows in db with specified sku
                $this->gateway->massDelete($data["skuList"]);

                http_response_code(204);
                break;
        }
    }

    private function checkUri(string $method, array $uri): void
    {
        // "" or "add-product"
        $resource = $uri[1];

        switch ($method) {
            case "GET":
            case "DELETE":
                if ($resource !== "") {
                    http_response_code(404);
                    echo json_encode([
                        "message" => "Page not found"
                    ]);
                    exit;
                }
                break;

            case "POST":
                if ($resource !== "add-product") {
                    http_response_code(404);
                    echo json_encode([
                        "message" => "Page not found"
                    ]);
                    exit;
                }
                break;
        }
    }

    // TODO rewrite in Product class method ???
    // TODO rewrite for better validation
    // Get array of validation errors
    private function getValidationErrors(array $data): array
    {
        $errors = [];

        // Check for empty inputs
        empty($data["sku"]) && $errors[] = "SKU is required";
        empty($data["name"]) && $errors[] = "Name is required";
        empty($data["price"]) && $errors[] = "Price is required";
        empty($data["type"]) && $errors[] = "Type is required";

        // Check for invalid values
        $data["price"] <= 0 && $errors[] = "Invalid value for price";

        // Check for corresponding properties for each type of product
        switch ($data["type"]) {
            case "book":
                empty($data["weight"]) && $errors[] = "Weight is required for type book";
                $data["weight"] <= 0 && $errors[] = "Invalid value for weight";

                break;
            case "dvd":
                empty($data["size"]) && $errors[] = "Size is required for type dvd";
                $data["size"] <= 0 && $errors[] = "Invalid value for size";

                break;
            case "furniture":
                empty($data["height"]) && $errors[] = "Height is required for type furniture";
                empty($data["width"]) && $errors[] = "Width is required for type furniture";
                empty($data["length"]) && $errors[] = "Length is required for type furniture";
                $data["height"] <= 0 && $errors[] = "Invalid value for height";
                $data["width"] <= 0 && $errors[] = "Invalid value for width";
                $data["length"] <= 0 && $errors[] = "Invalid value for length";

                break;
            default:
                $errors[] = "Invalid type of product";
        }

        return $errors;
    }
}