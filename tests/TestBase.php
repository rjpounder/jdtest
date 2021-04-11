<?php

namespace Tests;

use JDTest\Objects\CsvResource;
use JDTest\Objects\JsonResource;
use PHPUnit\Framework\TestCase;

abstract class TestBase extends TestCase
{
    public function loadCsv($path): CsvResource
    {
        return new CsvResource(
            file_get_contents($this->resolvePath($path, 'csv'))
        );
    }

    /**
     * @throws \JDTest\Exceptions\JsonFormatException
     */
    public function loadJson($path): JsonResource
    {
        return new JsonResource(
            file_get_contents($this->resolvePath($path, 'json'))
        );
    }

    private function resolvePath($path, $type)
    {
        return sprintf(
            '%s/_data/%s.'.$type,
            dirname(__FILE__),
            str_replace('.', '/', $path)
        );
    }
}
