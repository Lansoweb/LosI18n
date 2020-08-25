<?php

declare(strict_types=1);

namespace LosI18n\Service;

use Psr\Container\ContainerInterface;

class LanguageServiceFactory
{
    public function __invoke(ContainerInterface $container): LanguageService
    {
        $config      = $container->has('config') ? $container->get('config') : [];
        $path        = $config['los_i18n']['path'] ?? 'vendor/los/losi18n-data/data';
        $defaultLang = $config['los_i18n']['default_lang'] ?? 'en';

        return new LanguageService($path, $defaultLang);
    }
}
