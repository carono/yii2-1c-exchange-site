<?php
use \app\models\Offer;
use app\models\Price;

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'modules' => [
        'exchange' => [
            'class' => 'carono\exchange1c\ExchangeModule',
            'productClass' => 'app\models\Product',
            'documentClass' => '\app\models\Order',
            'exchangeDocuments' => true,
            'debug' => true,
            'on beforeUpdateProduct' => function ($event) {
                /**
                 * @var \app\models\Product $model
                 */
                /*
                $model = $event->model;
                foreach ($model->images as $image) {
                    $image->deleteFile();
                    $image->delete();
                }
                unset($image);
                unset($event);
                */
            },
            'on beforeUpdateOffer' => function ($event) {
                /**
                 * @var \carono\exchange1c\ExchangeEvent $event
                 * @var Offer $offer
                 */
                /*
                $model = $event->model;
                $ml = $event->ml;
                foreach (Offer::find()->andWhere(['accounting_id' => $ml->id])->batch() as $offers) {
                    foreach ($offers as $offer) {
                        if ($offer->price && $offer->price->type) {
                            $offer->price->type->delete();
                        } elseif ($offer->price) {
                            $offer->price->delete();
                        } else {
                            $offer->delete();
                        }
                    }
                }
                */
            },
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
                    'sourceLanguage' => 'ru',
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
                ['class' => 'carono\exchange1c\UrlRule'],
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
