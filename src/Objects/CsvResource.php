<?php

namespace JDTest\Objects;

class CsvResource extends Resource
{
    private $data;

    public function __construct(string $data = '')
    {
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->data;
    }

    public function toArray()
    {
        $csv = array_map(
            'str_getcsv',
            explode("\n", $this->data)
        );

        return $this->cleanCsv($csv);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    private function cleanCsv($csv): array
    {
        return array_filter($this->mapCsv($csv), function ($e) {
            return !is_bool($e);
        });
    }

    private function mapCsv($csv): array
    {
        return array_map(function ($values) {
            foreach ($values as $i => $value) {
                if (!$value) {
                    return false;
                }
                $values[$i] = trim($value);
            }

            return $values;
        }, $csv);
    }
}
