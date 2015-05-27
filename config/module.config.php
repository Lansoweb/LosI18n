<?php
return [
    'controllers' => [
        'invokables' => [
            'LosI18n\Controller\Index' => 'LosI18n\Controller\IndexController',
            'LosI18n\Controller\Console' => 'LosI18n\Controller\ConsoleController',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'LosI18n\Service\LanguageService' => 'LosI18n\Service\LanguageServiceFactory',
            'LosI18n\Service\CountryService' => 'LosI18n\Service\CountryServiceFactory',
            'LosI18n\Service\BuilderService' => 'LosI18n\Service\BuilderServiceFactory',
            'losi18n-languages' => 'LosI18n\Service\LanguageServiceFactory',
            'losi18n-countries' => 'LosI18n\Service\CountryServiceFactory',
            'losi18n-builder' => 'LosI18n\Service\BuilderServiceFactory',
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'losi18n-build' => [
                    'options' => [
                        'route' => 'losi18n build <source> <destination> [<language>] [<format>] ',
                        'defaults' => [
                            '__NAMESPACE__' => 'LosI18n\Controller',
                            'controller' => 'Console',
                            'action' => 'build',
                        ],
                    ],
                ],
                'losi18n-download' => [
                    'options' => [
                        'route' => 'losi18n download <destination> <language> [<format>]',
                        'defaults' => [
                            '__NAMESPACE__' => 'LosI18n\Controller',
                            'controller' => 'Console',
                            'action' => 'download',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'los-i18n' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '[/:lang]',
                            'constraints' => [
                                'lang' => '[a-z]{2}_[A-Z]{2}',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'LosI18n\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                                'lang' => 'pt_BR',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'los-i18n' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '[/:lang]',
                    'constraints' => [
                        'lang' => '[a-z]{2}-[a-z]{2}',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'LosI18n\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                        'lang' => 'pt-br',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'LosI18n' => __DIR__.'/../view',
        ],
    ],
];
