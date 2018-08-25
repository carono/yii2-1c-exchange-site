<?php

use app\models\Group;
use app\models\Offer;
use app\models\Order;
use app\models\Product;
use app\models\User;

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
//        'redactor' => [
//            'class' => 'yii\redactor\RedactorModule',
//            'uploadDir' => '@vendor/carono/yii2-1c-exchange/files/articles',
//            'imageAllowExtensions' => ['jpg', 'png', 'gif'],
//            'on beforeAction' => function () {
//                $path = ModuleHelper::getModuleNameByClass('carono\exchange1c\ExchangeModule', 'exchange');
//                $redactor = \Yii::$app->getModule('redactor');
//                $redactor->uploadUrl = "/$path/file/article?file=";
//                \Yii::$app->setModule('redactor', $redactor);
//            }
//        ],
        'exchange' => [
            'class' => 'carono\exchange1c\ExchangeModule',
            'productClass' => Product::class,
            'documentClass' => Order::class,
            'groupClass' => Group::class,
            'offerClass' => Offer::class,
            'partnerClass' => User::class,
            'exchangeDocuments' => true,
            'debug' => true
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JGAbCmLDtMMCqsJeRpmF7WeKmnzsLXLM',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
                ],
            ],
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'images/<id>/<name>' => 'site/image',
            ],
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
