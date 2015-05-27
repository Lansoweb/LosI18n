<?php
namespace LosI18n\Service;

final class CountryService
{
    private $translatedTo;

    private $path = 'vendor/los/losi18n-data/data';

    public function getTranslatedTo()
    {
        return $this->translatedTo;
    }

    public function setTranslatedTo($translatedTo)
    {
        $this->translatedTo = (string) $translatedTo;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = (string) $path;

        return $this;
    }

    public function getAllCountries($translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->translatedTo;
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
            $translatedTo = $this->translatedTo;
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
