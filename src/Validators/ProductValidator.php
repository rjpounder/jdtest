<?php

namespace JDTest\Validators;

use JDTest\Objects\ProductResource;

class ProductValidator
{
    /**
     * @var ProductResource
     */
    private $productResource;
    /**
     * @var array
     */
    private $config;

    public function __construct()
    {
        $this->config = require __DIR__.'/../Configs/products.php';
    }

    public function isValid(ProductResource $productResource)
    {
        $this->productResource = $productResource;

        if (!$this->validate()) {
            return false;
        }

        return true;
    }

    private function validate()
    {
        return $this->validateName()
            && $this->validateSku()
            && $this->validatePlu()
            && $this->validateSizeSort()
            && $this->validateSize();
    }

    private function validateSku(): bool
    {
        return is_numeric($this->productResource->sku);
    }

    private function validatePlu(): bool
    {
        return is_string($this->productResource->plu);
    }

    private function validateName(): bool
    {
        return is_string($this->productResource->name) && strlen($this->productResource->name) < 40;
    }

    private function validateSize(): bool
    {
        return $this->{'size'.$this->config['sorts'][$this->productResource->sizeSort]}();
    }

    private function validateSizeSort(): bool
    {
        return in_array($this->productResource->sizeSort, array_flip($this->config['sorts']));
    }

    /**
     * Below are size Functions called by validateSize();
     * ======================================.
     */
    private function sizeShoeEu()
    {
        return $this->productResource->size >= 20 && $this->productResource->size <= 50;
    }

    private function sizeClothingSort()
    {
        return in_array($this->productResource->sizeSort, $this->config['clothing_sizes']);
    }

    private function sizeShoeUk()
    {
        return is_float($this->productResource->size) ||
            in_array($this->productResource->size, $this->config['uk_child_shoe_sizes']);
    }
}
