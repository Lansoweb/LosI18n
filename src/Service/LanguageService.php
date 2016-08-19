<?php
namespace LosI18n\Service;

final class LanguageService
{
    private $defaultLang;
    private $path;

    public function __construct($path, $defaultLang)
    {
        $this->path = $path;
        $this->defaultLang = $defaultLang;
    }

    public function getAllLanguages($translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/languages.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        return include $fileName;
    }

    public function getNativeLanguages()
    {
        $fileName = $this->path.'/natives/languages.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Native language file not found.");
        }

        return include $fileName;
    }

    public function getLanguage($language, $translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/languages.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        $list = include $fileName;
        if (!is_array($list)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }
        if (!array_key_exists($language, $list)) {
            throw new \InvalidArgumentException("Language $language not found for $translatedTo.");
        }

        return $list[$language];
    }
}
