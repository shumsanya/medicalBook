<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'layout' => 'newDesign',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'timezone',
        'log'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'kXP9UzB0dR1qsJU_-KogUmpuRE4UTAA5',
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
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'kralechka74@gmail.com',
                'password' => '06061974',
                'port' => '587',
                'encryption' => 'tls',
                'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false, ], ]
            ],
        ],
        // получить текущее время пользователя (https://packagist.org/packages/yii2mod/yii2-timezone)
        'timezone' => [
            'class' => 'yii2mod\timezone\Timezone',
            'actionRoute' => '/site/timezone' //optional param - full path to page must be specified
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false, // строгий разбор URL, запрошенный URL должен соответствовать хотя бы одному из правил, иначе будет вызвано исключение
            'rules' => [
                //Вызывает любой контроллер и его любой экшен.
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                //Вызывает контроллер SitemapController и actionLogin() или actionLogout() или actionSignup()
                '<action:(login|logout|signup)>' => 'site/<action>',

                //Вызывает контроллер Controller и action($alias)
                '<controller:\w+>/<action:\w+>/<alias:[\w_-]+>' => '<controller>/<action>',

                //вход ,регистрация ,восстан. пароля, замена пароля
                '<action:(login|logout|signup|confirm-email|request-password-reset|reset-password)>' => 'login/<action>',

                /* '<controller:(post|comment)>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
                 '<controller:(post|comment)>/<id:\d+>' => '<controller>/view',
                 '<controller:(post|comment)>s' => '<controller>/index',*/
            ],
        ],

        //***  убрать (not set)/(не задано) в GridView
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ]

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
