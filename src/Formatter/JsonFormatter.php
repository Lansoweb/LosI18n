<?php
namespace LosI18n\Formatter;

class JsonFormatter extends AbstractFormatter
{
    public function format(array $data): string
    {
        return \json_encode($data);
    }

    public function getExtension(): string
    {
        return 'json';
    }
}
