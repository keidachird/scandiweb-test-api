<?php

namespace App;

class ProductValidator {
    private static array $validTypes = ["book", "dvd", "furniture"];
    private static array $validAttributes = [
        "book" => ["weight"],
        "dvd" => ["size"],
        "furniture" => ["height", "width", "length"]
    ];

    public static function validate(array $data): array {
        $errors = [];

        // Check for empty fields
        empty($data["sku"]) && $errors[] = "SKU is required";
        empty($data["name"]) && $errors[] = "Name is required";
        empty($data["price"]) && $errors[] = "Price is required";
        empty($data["type"]) && $errors[] = "Type is required";
        if (!empty($errors)) return $errors;

        // Check for invalid values
        $data["price"] <= 0 && $errors[] = "Invalid value for price";
        !in_array($data["type"], self::$validTypes) && $errors[] = "Invalid product type";
        if (!empty($errors)) return $errors;


        // Check for invalid product attributes
        foreach (self::$validAttributes[$data["type"]] as $attribute) {
            empty($data[$attribute]) && $errors[] = ucfirst($attribute) . " is required for type " . $data["type"];
        }
        if (!empty($errors)) return $errors;

        foreach (self::$validAttributes[$data["type"]] as $attribute) {
            $data[$attribute] <= 0 && $errors[] = "Invalid value for " . $attribute;
        }

        return $errors;
    }
}