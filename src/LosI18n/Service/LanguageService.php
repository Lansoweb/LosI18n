<?php
namespace LosI18n\Service;

final class LanguageService
{
    private $language;

    private $path = 'vendor/los/losi18n-data/data';

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = (string) $language;

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

    public function getAllLanguages($language = null)
    {
        if (null === $language) {
            $language = $this->language;
        }
        $fileName = $this->path.'/'.$language.'/languages.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $language not found.");
        }

        return include $fileName;
    }
}
