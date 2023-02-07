<?php

class ProductDvd extends Product
{
    private float $size;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->type = "dvd";
        $this->size = $data["size"];
    }

    public function getSize(): float
    {
        return $this->size;
    }

    public function setSize(float $size): void
    {
        $this->size = $size;
    }

    public function getInfo(): array
    {
        $data = parent::getInfo();
        $data["size"] = $this->getSize();

        return $data;
    }
}