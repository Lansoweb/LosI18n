<?php

declare(strict_types=1);

namespace LosI18n\Service;

use InvalidArgumentException;

use function array_key_exists;
use function file_exists;
use function is_array;
use function sprintf;

final class LanguageService
{
    private string $defaultLang;
    private string $path;

    public function __construct(string $path, string $defaultLang)
    {
        $this->path        = $path;
        $this->defaultLang = $defaultLang;
    }

    /**
     * @return array<string,string>
     */
    public function getAllLanguages(string $translatedTo = ''): array
    {
        if ($translatedTo === '') {
            $translatedTo = $this->defaultLang;
        }

        $fileName = $this->path . '/' . $translatedTo . '/languages.php';
        if (! file_exists($fileName)) {
            throw new InvalidArgumentException(sprintf('Language %s not found.', $translatedTo));
        }

        return include $fileName;
    }

    /**
     * @return array<string,string>
     */
    public function getNativeLanguages(): array
    {
        $fileName = $this->path . '/natives/languages.php';
        if (! file_exists($fileName)) {
            throw new InvalidArgumentException('Native language file not found.');
        }

        return include $fileName;
    }

    public function getLanguage(string $language, string $translatedTo = ''): string
    {
        if (empty($translatedTo)) {
            $translatedTo = $this->defaultLang;
        }

        $fileName = $this->path . '/' . $translatedTo . '/languages.php';
        if (! file_exists($fileName)) {
            throw new InvalidArgumentException(sprintf('Language %s not found.', $translatedTo));
        }

        $list = include $fileName;
        if (! is_array($list)) {
            throw new InvalidArgumentException(sprintf('Language %s not found.', $translatedTo));
        }

        if (! array_key_exists($language, $list)) {
            throw new InvalidArgumentException(sprintf('Language %s not found for %s.', $language, $translatedTo));
        }

        return $list[$language];
    }
}
