<?php
namespace LosI18n\Service;

use LosI18n\Formatter\FormatterInterface;
use LosI18n\Formatter\PhpFormatter;
use LosI18n\Formatter\JsonFormatter;
use LosI18n\Formatter\CsvFormatter;
use Zend\ProgressBar\Adapter\Console;
use Zend\ProgressBar\ProgressBar;

final class BuilderService
{
    private $source;

    private $destination;

    private $formatter;

    private $language;

    private $natives = [];

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = (string) $language;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        if (!file_exists($source)) {
            throw new \InvalidArgumentException('Source directory does not exists.');
        }
        $this->source = (string) $source;

        return $this;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function setDestination($destination)
    {
        if (!file_exists($destination)) {
            throw new \InvalidArgumentException('Destination directory does not exists.');
        }

        if (!is_writable($destination)) {
            throw new \InvalidArgumentException('Destination directory is not writeable.');
        }

        $this->destination = (string) $destination;

        return $this;
    }

    public function getFormatter()
    {
        return $this->formatter;
    }

    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    private function getLanguages($xml)
    {
        if (!isset($xml->localeDisplayNames->languages->language)) {
            return [];
        }
        $vet = $xml->localeDisplayNames->languages->language;
        $langs = [];
        foreach ($vet as $l) {
            $attrs = $l->attributes();
            $code = $attrs->type->__toString();
            if (strlen($code) === 2) {
                $langs[$code] = $l->__toString();
            }
        }

        return $langs;
    }

    private function getCountries($xml)
    {
        if (!isset($xml->localeDisplayNames->territories->territory)) {
            return [];
        }
        $vet = $xml->localeDisplayNames->territories->territory;
        $countries = [];
        foreach ($vet as $l) {
            $attrs = $l->attributes();
            $key = $attrs->type->__toString();
            if (is_numeric($key)) {
                $key = (int) $key;
            }
            $countries[$key] = $l->__toString();
        }

        return $countries;
    }

    private function saveLanguages($language, array $list)
    {
        if (isset($list[$language])) {
            $this->natives[$language] = $list[$language];
        }
        $dst = $this->destination."/$language";
        if (!file_exists($dst)) {
            mkdir($dst);
        }
        if ($this->formatter !== null) {
            file_put_contents($dst.'/languages.'.$this->formatter->getExtension(), $this->formatter->format($list));

            return;
        }

        $formatter = new PhpFormatter();
        file_put_contents($dst.'/languages.'.$formatter->getExtension(), $formatter->format($list));
        $formatter = new JsonFormatter();
        file_put_contents($dst.'/languages.'.$formatter->getExtension(), $formatter->format($list));
        $formatter = new CsvFormatter();
        file_put_contents($dst.'/languages.'.$formatter->getExtension(), $formatter->format($list));
    }

    private function saveNativeLanguages(array $list)
    {
        $dst = $this->destination."/natives";
        if (!file_exists($dst)) {
            mkdir($dst);
        }
        if ($this->formatter !== null) {
            file_put_contents($dst.'/languages.'.$this->formatter->getExtension(), $this->formatter->format($list));

            return;
        }

        $formatter = new PhpFormatter();
        file_put_contents($dst.'/languages.'.$formatter->getExtension(), $formatter->format($list));
        $formatter = new JsonFormatter();
        file_put_contents($dst.'/languages.'.$formatter->getExtension(), $formatter->format($list));
        $formatter = new CsvFormatter();
        file_put_contents($dst.'/languages.'.$formatter->getExtension(), $formatter->format($list));
    }

    private function saveCountries($language, array $list)
    {
        $dst = $this->destination."/$language";
        if (!file_exists($dst)) {
            mkdir($dst);
        }
        if ($this->formatter !== null) {
            file_put_contents($dst.'/countries.'.$this->formatter->getExtension(), $this->formatter->format($list));

            return;
        }
        $formatter = new PhpFormatter();
        file_put_contents($dst.'/countries.'.$formatter->getExtension(), $formatter->format($list));
        $formatter = new JsonFormatter();
        file_put_contents($dst.'/countries.'.$formatter->getExtension(), $formatter->format($list));
        $formatter = new CsvFormatter();
        file_put_contents($dst.'/countries.'.$formatter->getExtension(), $formatter->format($list));
    }

    private function buildForLang($language)
    {
        $xml = simplexml_load_file("{$this->source}/{$language}.xml");

        $identityLanguage = $xml->identity->language->attributes()->type;
        // This language has a parent, load the parent and merge the arrays
        $parentLanguages = [];
        if ($identityLanguage != $language) {
            $parentXml = simplexml_load_file("{$this->source}/{$identityLanguage}.xml");
            $parentLanguages = $this->getLanguages($parentXml);
        }

        $languages = $this->getLanguages($xml);
        if (!empty($parentLanguages)) {
            $languages = array_merge($parentLanguages, $languages);
        }

        $this->saveLanguages($language, $languages);

        $parentCountries = [];
        //This language has a parent, load the parent and merge the arrays
        if ($identityLanguage != $language) {
            $parentCountries = $this->getCountries($parentXml);
        }

        $countries = $this->getCountries($xml);
        if (!empty($parentCountries)) {
            $countries = array_merge($parentCountries, $countries);
        }

        $this->saveCountries($language, $countries);
    }

    public function build()
    {
        if (empty($this->source)) {
            throw new \RuntimeException('Source directory not defined.');
        }
        if (empty($this->destination)) {
            throw new \RuntimeException('Destination directory not defined.');
        }

        if (!empty($this->language)) {
            $this->buildForLang($this->language);

            return;
        }

        $fileList = glob("$this->source/*.xml");

        $adapter = new Console();
        $progressBar = new ProgressBar($adapter, 0, count($fileList) + 1);
        $counter = 0;
        foreach ($fileList as $fileName) {
            $posDot = strrpos($fileName, '.');
            $posSlash = strrpos($fileName, '/');
            $language = substr($fileName, $posSlash + 1, $posDot - $posSlash - 1);
            // Only 'pt' or 'pt_BR' like (not "dead" languages like arc=Aramaic)
            if (strlen($language) == 2 || strlen($language) == 5) {
                $this->buildForLang($language);
            }
            $progressBar->update($counter++, 0);
        }
        if (count($this->natives) > 0) {
            $this->saveNativeLanguages($this->natives);
        }
        $progressBar->finish();
    }
}
