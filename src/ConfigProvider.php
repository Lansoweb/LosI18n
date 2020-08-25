<?php

declare(strict_types=1);

namespace LosI18n;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                Service\LanguageService::class => Service\LanguageServiceFactory::class,
                Service\CountryService::class => Service\CountryServiceFactory::class,
                Service\RegionService::class => Service\RegionServiceFactory::class,
                'losi18n-languages' => Service\LanguageServiceFactory::class,
                'losi18n-countries' => Service\CountryServiceFactory::class,
                'losi18n-regions' => Service\RegionServiceFactory::class,
            ],
        ];
    }
}
