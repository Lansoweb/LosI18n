<?php

declare(strict_types=1);

namespace LosI18n\Formatter;

use function fclose;
use function fopen;
use function fputcsv;
use function rewind;
use function stream_get_contents;

class CsvFormatter implements Formatter
{
    public function format(array $data): string
    {
        $outstream = fopen('php://temp', 'r+');
        fputcsv($outstream, [
            'iso',
            'name',
        ]);
        foreach ($data as $iso => $name) {
            fputcsv($outstream, [
                $iso,
                $name,
            ]);
        }

        rewind($outstream);
        $csv = stream_get_contents($outstream);
        fclose($outstream);

        return $csv;
    }

    public function getExtension(): string
    {
        return 'csv';
    }
}
