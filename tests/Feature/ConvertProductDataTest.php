<?php

namespace Tests\Feature;

use JDTest\ConvertDataFeed;
use Tests\TestBase;

class ConvertProductDataTest extends TestBase
{
    /**
     * @test
     *
     * @throws \JDTest\Exceptions\JsonFormatException
     */
    public function examplePayloadIsConvertedToJsonPayload()
    {
        //init
        $data = $this->loadCsv('provided.example');
        $expectedData = $this->loadJson('provided.expected');
        //process
        $convertDataFeed = new ConvertDataFeed($data);
        //check
        $this->assertEquals($expectedData->toJson(), $convertDataFeed->toJson());
    }

    /**
     * @test
     */
    public function invalidSizesAreIgnored()
    {
        //init
        $data = $this->loadCsv('validator.input');
        $expectedData = $this->loadJson('validator.expected');
        //process
        $convertDataFeed = new ConvertDataFeed($data);
        //check
        $this->assertEquals($expectedData->toJson(), $convertDataFeed->toJson());
    }
}
