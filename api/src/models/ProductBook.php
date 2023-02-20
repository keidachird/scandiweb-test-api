<?php

class ProductBook extends Product
{
    private float $weight;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if (array_key_exists("attribute", $data)) {
            $this->attribute = $data["attribute"];
            $this->weight = (float)$this->attribute;
        } else {
            $this->weight = $data["weight"];
            $this->attribute = $this->weight . ' Kg';
        }
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }
}