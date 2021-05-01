<?php

declare(strict_types=1);

namespace LosI18n\Formatter;

use RuntimeException;

use function fclose;
use function fopen;
use function fputcsv;
use function rewind;
use function stream_get_contents;

class CsvFormatter implements Formatter
{
    /**
     * @param array<string|int,string> $data
     */
    public function format(array $data): string
    {
        $outStream = fopen('php://temp', 'r+');

        if ($outStream === false) {
            throw new RuntimeException('Unable to open temp resource');
        }

        fputcsv($outStream, [
            'iso',
            'name',
        ]);
        foreach ($data as $iso => $name) {
            fputcsv($outStream, [
                $iso,
                $name,
            ]);
        }

        rewind($outStream);
        $csv = stream_get_contents($outStream);

        if ($csv === false) {
            throw new RuntimeException('Unable to read temp resource');
        }

        fclose($outStream);

        return $csv;
    }

    public function getExtension(): string
    {
        return 'csv';
    }
}
