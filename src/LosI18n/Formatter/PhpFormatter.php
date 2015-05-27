<?php
namespace LosI18n\Formatter;

class PhpFormatter extends AbstractFormatter
{
    public function format(array $data)
    {
        $str = sprintf("<?php\nreturn %s;%s", var_export($data, true), PHP_EOL);
        $str = str_replace('array (', '[', $str);
        $str = str_replace(');', '];', $str);
        $str = str_replace('  ', '    ', $str);

        return $str;
    }

    public function getExtension()
    {
        return 'php';
    }
}
