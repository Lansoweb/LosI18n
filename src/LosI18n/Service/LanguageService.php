<?php
namespace LosI18n\Service;

final class LanguageService
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

    public function getAllLanguages($translatedTo = null)
    {
        if (null === $translatedTo) {
            $translatedTo = $this->translatedTo;
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
            $translatedTo = $this->translatedTo;
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
