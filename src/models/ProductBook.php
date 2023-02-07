<?php

class ProductBook extends Product
{
    private float $weight;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->type = "book";
        $this->weight = $data["weight"];
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function getInfo(): array
    {
        $data = parent::getInfo();
        $data["weight"] = $this->getWeight();

        return $data;
    }
}