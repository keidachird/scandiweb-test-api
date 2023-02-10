<?php

class ProductFurniture extends Product
{
    private float $height;
    private float $width;
    private float $length;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->type = "furniture";
        $this->height = $data["height"];
        $this->width = $data["width"];
        $this->length = $data["length"];
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

    public function getInfo(): array
    {
        $data = parent::getInfo();
        $data["height"] = $this->getHeight();
        $data["width"] = $this->getWidth();
        $data["length"] = $this->getLength();

        return $data;
    }
}