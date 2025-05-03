<?php

return [
    'default' => 'default',

    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'TaskHub-API Documentation',
            ],

            'routes' => [
                'api' => 'api/documentation',
                'docs' => 'docs',
                'oauth2_callback' => 'api/oauth2-callback',
                'middleware' => [
                    'api' => ['swagger.access'],
                    'docs' => [],
                    'oauth2_callback' => [],
                ],
            ],

            'paths' => [
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'annotations' => [
                    base_path('app'),
                ],
                'docs' => storage_path('api-docs'),
                'views' => base_path('resources/views/vendor/l5-swagger'),
                'base' => env('L5_SWAGGER_BASE_PATH', null),
            ],
        ],
    ],


    'proxy' => false,

    'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),

    'generate_yaml_copy' => false,

    'swagger_version' => env('SWAGGER_VERSION', '3.0'),

    'constants' => [
        'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://taskhub-api.test'),
    ],

    'securityDefinitions' => [
        'securitySchemes' => [
            'sanctum' => [
                'type' => 'apiKey',
                'description' => 'Enter token in format (Bearer <token>)',
                'name' => 'Authorization',
                'in' => 'header',
            ],
        ],
        'security' => [
            [
                'sanctum' => [],
            ],
        ],
    ],
];
