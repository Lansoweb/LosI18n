<?php
namespace LosI18n;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ConsoleUsageProviderInterface
{
    public function getConfig()
    {
        return include __DIR__.'/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__.'/../../src/'.__NAMESPACE__,
                ],
            ],
        ];
    }

    public function getConsoleUsage(Console $console)
    {
        return [
            'losi18n download <destination> [<language>] [<format>]'    => 'Download the i18n files',

            [ 'destination',   'Path where the module will save the files.' ],
            [ 'language',      'Language to be downloaded. Can specify multiple languages separated by a comma (,)' ],
            [ 'format',        'Format of the files to be downloaded. Can specify multiple formats separated by a comma (,)' ],
            [ '--verbose|-v',  '(optional) turn on verbose mode'        ],

            'losi18n build [--verbose|-v] <source> <destination> [<language>] [<format>]'    => 'Build the i18n files',

            [ 'source',        'Path to CLRD files.' ],
            [ 'destination',   'Path where the module will save the files.' ],
            [ 'language',      'Language to be used. Ommit will generate for ALL languages.' ],
            [ 'format',        'Format of the files to be saved.' ],
            [ '--verbose|-v',  '(optional) turn on verbose mode'        ],

            "Available formats: csv, json and php.\n",
        ];
    }
}
