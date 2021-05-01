<?php

declare(strict_types=1);

namespace LosI18n\Service;

use Psr\Container\ContainerInterface;

class RegionServiceFactory
{
    public function __invoke(ContainerInterface $container): RegionService
    {
        $config      = $container->get('config');
        $path        = $config['los_i18n']['path'] ?? 'vendor/los/losi18n-data/data';
        $defaultLang = $config['los_i18n']['default_lang'] ?? 'en';

        return new RegionService($path, $defaultLang);
    }
}
