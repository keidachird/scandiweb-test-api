<?php

namespace App;

class ProductFurniture extends Product
{
    private float $height;
    private float $width;
    private float $length;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if (array_key_exists("attribute", $data)) {
            $this->attribute = $data["attribute"];
            $attribute_parts = explode("x", $this->attribute);
            $this->height = $attribute_parts[0];
            $this->width = $attribute_parts[1];
            $this->length = $attribute_parts[2];
        } else {
            $this->height = $data["height"];
            $this->width = $data["width"];
            $this->length = $data["length"];
            $this->attribute = $this->height . "x" . $this->width . "x" . $this->length;
        }
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function setWidth(float $width): void
    {
        $this->width = $width;
    }

    public function getLength(): float
    {
        return $this->length;
    }

    public function setLength(float $length): void
    {
        $this->length = $length;
    }
}