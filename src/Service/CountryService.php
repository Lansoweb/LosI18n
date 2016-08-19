<?php
namespace LosI18n\Service;

final class CountryService
{
    private $defaultLang;
    private $path;

    public function __construct($path, $defaultLang)
    {
        $this->path = $path;
        $this->defaultLang = $defaultLang;
    }

    public function getAllCountries($translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/countries.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        return include $fileName;
    }

    public function getCountry($country, $translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/countries.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        $list = include $fileName;
        if (!is_array($list)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }
        $country = strtoupper($country);
        if (!array_key_exists($country, $list)) {
            throw new \InvalidArgumentException("Country $country not found for $translatedTo.");
        }

        return $list[$country];
    }
}
