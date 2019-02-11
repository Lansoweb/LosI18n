<?php
declare(strict_types=1);

namespace LosI18n\Service;

final class LanguageService
{
    private $defaultLang;
    private $path;

    /**
     * LanguageService constructor.
     * @param string $path
     * @param string $defaultLang
     */
    public function __construct(string $path, string $defaultLang)
    {
        $this->path = $path;
        $this->defaultLang = $defaultLang;
    }

    /**
     * @param string $translatedTo
     * @return array
     */
    public function getAllLanguages(string $translatedTo = ''): array
    {
        if ('' === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/languages.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        return include $fileName;
    }

    /**
     * @return array
     */
    public function getNativeLanguages(): array
    {
        $fileName = $this->path.'/natives/languages.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Native language file not found.");
        }

        return include $fileName;
    }

    /**
     * @param string $language
     * @param string $translatedTo
     * @return array
     */
    public function getLanguage(string $language, string $translatedTo = ''): array
    {
        if (null === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/languages.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        $list = include $fileName;
        if (! is_array($list)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }
        if (! array_key_exists($language, $list)) {
            throw new \InvalidArgumentException("Language $language not found for $translatedTo.");
        }

        return $list[$language];
    }
}
