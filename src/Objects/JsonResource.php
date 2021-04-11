<?php

namespace JDTest\Objects;

use JDTest\Exceptions\JsonFormatException;

class JsonResource extends Resource
{
    private $data;

    public function __construct(string $data = '')
    {
        $this->data = $data;
        try {
            json_decode($data, true);
        } catch (JsonFormatException $exception) {
            throw $exception;
        }
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function toArray()
    {
        return json_decode($this->data, true);
    }

    public function toJson()
    {
        return json_encode(json_decode($this->data, true));
    }
}
