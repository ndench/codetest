<?php

use app\serializer\handler\LotteryApiResultHandler;
use app\serializer\handler\LotteryTicketHandler;
use app\serializer\handler\RaffleTicketHandler;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'WvKoMZi-2qetsg8NsnbuYU6J8Jd1CkhE',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'serializer' => [
            'class' => 'krtv\yii2\serializer\Serializer',
            'formats' => [
                'json',
            ],

            'handlers' => [
//               'datetime' => [
//                   'defaultFormat' => 'c',  // ISO8601
//               ],
               'lottery_api_result_handler' => [
                   'class' => LotteryApiResultHandler::class,
               ],
               'lottery_ticket_handler' => [
                   'class' => LotteryTicketHandler::class,
               ],
               'raffle_ticket_handler' => [
                   'class' => RaffleTicketHandler::class,
               ],
            ],

            // Uncomment if you would like to use different naming strategy for properties.
            // "camel_case" is a default one. Available strategies are: "camel_case", "identical" and "custom".
            //
            // 'namingStrategy' => [
            //     'name' => 'camel_case',
            //     'options' => [
            //         'separator' => '_',
            //         'lowerCase' => true,
            //     ],
            // ],

            // Uncomment if you would like to configure class-metadata or enable cache.
            //
            // 'metadata' => [
            //     'cache' => true,
            //     'directories' => [
            //         [
            //             'namespace' => 'Foo\\Bar',
            //             'alias' => '@app/config/serializer/foo/bar',
            //         ],
            //         // ...
            //     ]
            // ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
