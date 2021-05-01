<?php

declare(strict_types=1);

namespace LosI18n\Formatter;

interface Formatter
{
    /**
     * @param array<string|int,string> $data
     */
    public function format(array $data): string;
}
