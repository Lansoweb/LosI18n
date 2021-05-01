<?php

declare(strict_types=1);

namespace LosI18n\Service;

use InvalidArgumentException;

use function array_key_exists;
use function file_exists;
use function is_array;
use function sprintf;

final class RegionService
{
    private string $defaultLang;
    private string $path;

    public function __construct(string $path, string $defaultLang)
    {
        $this->path        = $path;
        $this->defaultLang = $defaultLang;
    }

    /**
     * @return array<int,string>
     */
    public function getAllRegions(string $translatedTo = ''): array
    {
        if ($translatedTo === '') {
            $translatedTo = $this->defaultLang;
        }

        $fileName = $this->path . '/' . $translatedTo . '/regions.php';
        if (! file_exists($fileName)) {
            throw new InvalidArgumentException(sprintf('Language %s not found.', $translatedTo));
        }

        return include $fileName;
    }

    public function getRegion(string $region, string $translatedTo = ''): string
    {
        if ($translatedTo === '') {
            $translatedTo = $this->defaultLang;
        }

        $fileName = $this->path . '/' . $translatedTo . '/regions.php';
        if (! file_exists($fileName)) {
            throw new InvalidArgumentException(sprintf('Language %s not found.', $translatedTo));
        }

        $list = include $fileName;
        if (! is_array($list)) {
            throw new InvalidArgumentException(sprintf('Language %s not found.', $translatedTo));
        }

        if (! array_key_exists($region, $list)) {
            throw new InvalidArgumentException(sprintf('Region %s not found for %s.', $region, $translatedTo));
        }

        return $list[$region];
    }
}
