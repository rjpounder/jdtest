<?php

namespace JDTest\Contracts;

use JDTest\Objects\CsvResource;

interface ConvertDataFeedContract
{
    public function __construct(CsvResource $csvResource);

    public function toJson(): string;

    public function toCsv(): CsvResource;
}
