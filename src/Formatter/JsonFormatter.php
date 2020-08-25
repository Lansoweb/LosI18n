<?php

declare(strict_types=1);

namespace LosI18n\Formatter;

use function json_encode;

class JsonFormatter implements Formatter
{
    public function format(array $data): string
    {
        return json_encode($data);
    }

    public function getExtension(): string
    {
        return 'json';
    }
}
