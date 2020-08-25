<?php

declare(strict_types=1);

namespace LosI18n\Formatter;

interface Formatter
{
    public function format(array $data): string;

    public function getExtension(): string;
}
