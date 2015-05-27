<?php
namespace LosI18n\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use LosI18n\Formatter\PhpFormatter;
use LosI18n\Formatter\JsonFormatter;
use LosI18n\Formatter\CsvFormatter;
use Zend\ProgressBar\Adapter\Console;
use Zend\ProgressBar\ProgressBar;

class ConsoleController extends AbstractActionController
{
    private static function downloadFile($url, $file)
    {
        $content = @file_get_contents($url);
        if (empty($content)) {
            return false;
        }

        return (file_put_contents($file, $content) !== false);
    }

    public function downloadAction()
    {
        $request = $this->getRequest();

        if (! $request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $destination = $request->getParam('destination', '');
        $languages = explode(',', $request->getParam('language', 'pt_BR'));
        $formats = explode(',', $request->getParam('format', 'php'));

        if (!file_exists($destination)) {
            throw new \InvalidArgumentException('Destination directory does not exists.');
        }
        if (!is_writable($destination)) {
            throw new \InvalidArgumentException('Destination directory is not writeable.');
        }

        $baseUrl = 'https://raw.githubusercontent.com/Lansoweb/losi18n-data/master/data/';

        echo "Downloading files ...\n";

        $adapter = new Console();
        $progressBar = new ProgressBar($adapter, 0, count($languages) * count($formats));
        $counter = 0;
        foreach ($languages as $language) {
            if (!file_exists("$destination/$language")) {
                mkdir("$destination/$language");
            }
            foreach ($formats as $format) {
                $this->downloadFile("$baseUrl/$language/languages.$format", "$destination/$language/languages.$format");
                $progressBar->update($counter++, 0);
                $this->downloadFile("$baseUrl/$language/countries.$format", "$destination/$language/countries.$format");
                $progressBar->update($counter++, 0);
            }
        }
        $progressBar->finish();
    }

    public function buildAction()
    {
        $request = $this->getRequest();

        if (! $request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $source = $request->getParam('source', '');
        $destination = $request->getParam('destination', '');
        $format = $request->getParam('format', 'all');
        $language = $request->getParam('language', null);

        $builder = $this->getServiceLocator()->get('LosI18n\Service\BuilderService');
        $builder->setSource($source);
        $builder->setDestination($destination);
        $builder->setLanguage($language);
        if ($format == 'php') {
            $formatter = new PhpFormatter();
        } elseif ($format == 'json') {
            $formatter = new JsonFormatter();
        } elseif ($format == 'csv') {
            $formatter = new CsvFormatter();
        } else {
            //all
            $formatter = null;
        }
        if ($formatter !== null) {
            $builder->setFormatter($formatter);
        }

        $builder->build();
    }
}
