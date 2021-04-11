<?php

header('Content-Type: application/json');

require '../vendor/autoload.php';

$data = new \JDTest\Objects\CsvResource(file_get_contents(__DIR__.'/../etc/task/products.csv'));
$exampleFeed = new \JDTest\ConvertDataFeed($data);
echo $exampleFeed->toJson();
