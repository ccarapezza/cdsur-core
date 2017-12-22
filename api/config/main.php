<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'cdsur-core',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'product',
                    'extraPatterns' => [
                        'GET code/<code>' => 'code',
                        'GET search' => 'search',
                        'POST searchpost' => 'searchpost',
                        'OPTIONS searchpost' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'category',
                    'extraPatterns' => [
                        'GET parent/<parentid>' => 'parent',
                        'GET parent' => 'parent',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'security',
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'OPTIONS login' => 'options',
                        'POST user-info' => 'user-info',
                        'OPTIONS user-info' => 'options',
                        'POST signup' => 'signup',
                        'OPTIONS signup' => 'options',
                        'GET confirm/<id>/<code>' => 'confirm',
                        'OPTIONS confirm' => 'confirm',
                        'POST test' => 'test',
                        'OPTIONS test' => 'test'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'cart',
                    'extraPatterns' => [
                        'POST send' => 'send',
                        'OPTIONS send' => 'options',
                    ]
                ],
            ],
        ],
        /*'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],*/
    ],
    'params' => $params,
];
