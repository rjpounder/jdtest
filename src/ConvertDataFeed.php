<?php

namespace JDTest;

use JDTest\Contracts\ConvertDataFeedContract;
use JDTest\Exceptions\InvalidProductException;
use JDTest\Objects\CsvResource;
use JDTest\Objects\ProductResource;
use JDTest\Validators\ProductValidator;

class ConvertDataFeed implements ConvertDataFeedContract
{
    private const SHOE_EU = 'SHOE_EU';
    private const CLOTHING = 'CLOTHING_SHORT';
    private const SHOE_UK = 'SHOE_UK';

    /**
     * @var CsvResource
     */
    private $csvResource;
    /**
     * @var array
     */
    private $cleanProductCollection;
    /**
     * @var mixed
     */
    private $config;

    /**
     * ConvertDataFeed constructor.
     */
    public function __construct(CsvResource $csvResource)
    {
        $this->config = require __DIR__.'/Configs/products.php';
        $this->csvResource = $csvResource;
        $this->process();
    }

    /**
     * @throws InvalidProductException
     */
    private function process()
    {
        $productFeed = $this->csvResource->toArray();

        $productValidator = new ProductValidator();
        $products = [];

        foreach ($productFeed as $product) {
            $product = new ProductResource($product);
            if (!$productValidator->isValid($product)) {
                logger('Invalid product; '.$product);

                continue;
            }

            $products[$product->plu][$product->name]['sizes'][$this->getSizeValue($product->size, $product->sizeSort)] = [
                'sku' => $product->sku,
                'size' => $product->size,
            ];
        }

        $this->cleanProductCollection = $this->orderSizes($products);
    }

    private function orderSizes($products)
    {
        foreach ($products as $i => $plus) {
            foreach ($plus as $j => $product) {
                $sizes = $product['sizes'];
                ksort($sizes);
                $products[$i][$j]['sizes'] = [];
                foreach ($sizes as $orderedSize) {
                    $products[$i][$j]['sizes'][] = $orderedSize;
                }
            }
        }

        return $products;
    }

    /**
     * Gets the system value for the size type.
     *
     * @param $size
     * @param $sizeSort
     *
     * @throws InvalidProductException
     */
    private function getSizeValue($size, $sizeSort)
    {
        //already been validated here.
        switch ($sizeSort) {
            case self::CLOTHING:
            case self::SHOE_EU:
                return (float) $size;
            case self::SHOE_UK:
                if (in_array($size, $this->config['uk_child_shoe_sizes'])) {
                    return array_search($size, $this->config['uk_child_shoe_sizes']);
                }
        }

        throw new InvalidProductException('Shouldn\'t ever get here');
    }

    /**
     * @throws Exceptions\JsonFormatException
     */
    public function toJson(): string
    {
        return json_encode($this->cleanProductCollection);
    }

    /**
     * @throws Exceptions\JsonFormatException
     */
    public function toArray(): array
    {
        return $this->cleanProductCollection;
    }

    public function toCsv(): CsvResource
    {
        return $this->csvResource;
    }
}
