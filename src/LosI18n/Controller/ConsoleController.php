<?php
namespace LosI18n\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use LosI18n\Formatter\PhpFormatter;
use LosI18n\Formatter\JsonFormatter;
use LosI18n\Formatter\CsvFormatter;

class ConsoleController extends AbstractActionController
{
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
