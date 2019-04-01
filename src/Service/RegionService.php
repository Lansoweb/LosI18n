<?php
declare(strict_types=1);

namespace LosI18n\Service;

final class RegionService
{
    private $defaultLang;
    private $path;

    public function __construct(string $path, string $defaultLang)
    {
        $this->path = $path;
        $this->defaultLang = $defaultLang;
    }

    public function getAllRegions(string $translatedTo = ''): array
    {
        if ('' === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/regions.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        return include $fileName;
    }

    public function getRegion(string $region, string $translatedTo = '')
    {
        if ('' === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/regions.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        $list = include $fileName;
        if (! is_array($list)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }
        if (! array_key_exists($region, $list)) {
            throw new \InvalidArgumentException("Region $region not found for $translatedTo.");
        }

        return $list[$region];
    }
}
