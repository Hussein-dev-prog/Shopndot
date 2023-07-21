<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-supplier',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'supplier\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-supplier',
            // 'parsers' => [
            //     'application/json' => 'yii\web\JsonParser',
            // ],

        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-supplier', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the supplier
            'name' => 'advanced-supplier',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'GET orders/<supplierId:\d+>' => '/panel/data',
                'GET orders/details/<id:\d+>' => '/order/details',
                'GET orders' => '/order/index',
                'POST orders' => '/order/create',
                'PUT orders/<id:\d+>' => '/order/update',
                'DELETE orders/<id:\d+>' => '/order/delete',
            ],
        ],
    ],
    'params' => $params,
];
