<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'LosI18n\Controller\Index' => 'LosI18n\Controller\IndexController',
            'LosI18n\Controller\Console' => 'LosI18n\Controller\ConsoleController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'LosI18n\Service\LanguageService' => 'LosI18n\Service\LanguageServiceFactory',
            'LosI18n\Service\BuilderService' => 'LosI18n\Service\BuilderServiceFactory',
            'losi18n-languages' => 'LosI18n\Service\LanguageServiceFactory',
            'losi18n-builder' => 'LosI18n\Service\BuilderServiceFactory',
        ),
    ),
    'console' => [
        'router' => [
            'routes' => [
                'losi18n-build' => [
                    'options' => [
                        'route' => 'losi18n build <source> <destination> [<format>] [<language>]',
                        'defaults' => [
                            '__NAMESPACE__' => 'LosI18n\Controller',
                            'controller' => 'Console',
                            'action' => 'build',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'los-i18n' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:lang]',
                            'constraints' => array(
                                'lang' => '[a-z]{2}_[A-Z]{2}',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'LosI18n\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                                'lang' => 'pt_BR',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
            'los-i18n' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '[/:lang]',
                    'constraints' => array(
                        'lang' => '[a-z]{2}-[a-z]{2}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'LosI18n\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                        'lang' => 'pt-br',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'LosI18n' => __DIR__.'/../view',
        ),
    ),
);
