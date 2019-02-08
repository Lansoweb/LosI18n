<?php
namespace LosI18n\Formatter;

abstract class AbstractFormatter implements FormatterInterface
{
    abstract public function format(array $data): string ;
    abstract public function getExtension(): string ;
}
