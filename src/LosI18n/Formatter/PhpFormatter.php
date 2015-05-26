<?php
namespace LosI18n\Formatter;

class PhpFormatter extends AbstractFormatter
{
    public function format(array $data)
    {
        return sprintf('<?php return %s;%s', var_export($data, true), PHP_EOL);
    }

    public function getExtension()
    {
        return 'php';
    }
}
