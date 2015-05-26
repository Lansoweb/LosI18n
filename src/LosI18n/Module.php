<?php
namespace LosI18n;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ConsoleUsageProviderInterface
{
    public function onBootstrap($e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $em = $sm->get('Doctrine\ORM\EntityManager');
    }

    public function getConfig()
    {
        return include __DIR__.'/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__.'/../../src/'.__NAMESPACE__,
                ),
            ),
        );
    }

    public function getConsoleUsage(Console $console)
    {
        return array(
            'losi18n build [--verbose|-v] <source> <destination> [<format>] [<language>]'    => 'Build the i18n files',

            array( 'source',        'Path to CLRD files.' ),
            array( 'destination',   'Path where the module will save the files.' ),
            array( 'format',        'Format of the files to be saved.' ),
            array( 'language',      'Language to be used. Ommit will generate for ALL languages.' ),
            array( '--verbose|-v',  '(optional) turn on verbose mode'        ),
        );
    }
}
