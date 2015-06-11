<?php
namespace LosI18n\Service;

final class RegionService
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

    public function getAllRegions($translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->translatedTo;
        }
        $fileName = $this->path.'/'.$translatedTo.'/regions.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        return include $fileName;
    }

    public function getRegion($region, $translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->translatedTo;
        }
        $fileName = $this->path.'/'.$translatedTo.'/regions.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        $list = include $fileName;
        if (!is_array($list)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }
        if (!array_key_exists($region, $list)) {
            throw new \InvalidArgumentException("Region $region not found for $translatedTo.");
        }

        return $list[$region];
    }
}
