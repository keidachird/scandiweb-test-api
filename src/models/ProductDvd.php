<?php

class ProductDvd extends Product
{
    private float $size;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if (array_key_exists("attribute", $data)) {
            $this->attribute = $data["attribute"];
            $this->size = (float)$this->attribute;
        } else {
            $this->size = $data["size"];
            $this->attribute = $this->size . ' MB';
        }
    }

    public function getSize(): float
    {
        return $this->size;
    }

    public function setSize(float $size): void
    {
        $this->size = $size;
    }
}