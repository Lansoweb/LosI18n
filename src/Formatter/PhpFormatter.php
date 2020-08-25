<?php

declare(strict_types=1);

namespace LosI18n\Formatter;

use function sprintf;
use function str_replace;
use function var_export;

use const PHP_EOL;

class PhpFormatter implements Formatter
{
    public function format(array $data): string
    {
        $str = sprintf("<?php\nreturn %s;%s", var_export($data, true), PHP_EOL);
        $str = str_replace('array (', '[', $str);
        $str = str_replace(');', '];', $str);
        $str = str_replace('  ', '    ', $str);

        return $str;
    }

    public function getExtension(): string
    {
        return 'php';
    }
}
