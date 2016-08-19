<?php
namespace LosI18n\Service;

final class RegionService
{
    private $defaultLang;
    private $path;

    public function __construct($path, $defaultLang)
    {
        $this->path = $path;
        $this->defaultLang = $defaultLang;
    }

    public function getAllRegions($translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->defaultLang;
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
            $translatedTo = $this->defaultLang;
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
