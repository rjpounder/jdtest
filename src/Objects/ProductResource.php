<?php

namespace JDTest\Objects;

use JDTest\Exceptions\InvalidProductException;

/**
 * Class ProductResource.
 *
 * @property $sku
 * @property $plu
 * @property $name
 * @property $size
 * @property $sizeSort
 */
class ProductResource extends Resource
{
    public function __construct(array $data = [])
    {
        if (5 !== count($data)) {
            throw new InvalidProductException('Incorrect properties, there should be 5.');
        }

        $this->sku = $data[0];
        $this->plu = $data[1];
        $this->name = $data[2];
        $this->size = $data[3];
        $this->sizeSort = $data[4];
    }

    public function __get(string $name)
    {
        return $this->$name ?? null;
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function toArray()
    {
        return [
            'sku' => $this->sku,
            'plu' => $this->plu,
            'name' => $this->name,
            'size' => $this->size,
            'sizeSort' => $this->sizeSort,
        ];
    }

    public function toJson()
    {
        return json_encode([
            'sku' => $this->sku,
            'plu' => $this->plu,
            'name' => $this->name,
            'size' => $this->size,
            'sizeSort' => $this->sizeSort,
        ]);
    }
}
