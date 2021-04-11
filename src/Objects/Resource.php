<?php

namespace JDTest\Objects;

abstract class Resource
{
    abstract public function __toString();

    abstract public function toArray();

    abstract public function toJson();
}
