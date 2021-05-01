<?php

declare(strict_types=1);

namespace LosI18n\Formatter;

use InvalidArgumentException;

use function json_encode;

class JsonFormatter implements Formatter
{
    /**
     * @param array<string|int,string> $data
     */
    public function format(array $data): string
    {
        $str = json_encode($data);

        if ($str === false) {
            throw new InvalidArgumentException('Invalid json $data provided');
        }

        return $str;
    }

    public function getExtension(): string
    {
        return 'json';
    }
}
