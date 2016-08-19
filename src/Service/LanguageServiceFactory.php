<?php
namespace LosI18n\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LanguageServiceFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\Factory\FactoryInterface::__invoke()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $path = $config['los_i18n']['path'] ?? 'vendor/los/losi18n-data/data';
        $defaultLang = $config['los_i18n']['default_lang'] ?? 'en';

        return new LanguageService($path, $defaultLang);
    }
}
