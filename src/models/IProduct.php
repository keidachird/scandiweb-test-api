<?php

interface IProduct
{
    public function getSku(): string;

    public function setSku(string $sku): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getPrice(): float;

    public function setPrice(float $price): void;

    public function getType(): string;

    public function setType(string $type): void;

    public function getInfo(): array;
}