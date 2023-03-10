<?php

namespace App;

abstract class Product
{
    protected string $sku;
    protected string $name;
    protected float $price;
    protected string $type;
    protected string $attribute;

    public function __construct(array $data)
    {
        $this->sku = $data["sku"];
        $this->name = $data["name"];
        $this->price = $data["price"];
        $this->type = $data["type"];
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function getInfo(): array
    {
        return [
            "sku" => $this->getSku(),
            "name" => $this->getName(),
            "price" => $this->getPrice(),
            "type" => $this->getType(),
            "attribute" => $this->getAttribute()
        ];
    }
}