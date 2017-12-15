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
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],*/
        'user' => [
            'identityClass' => 'dektrium\user\models\User',
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
                        'POST signup' => 'signup',
                        'POST secured' => 'secured',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'extraPatterns' => [
                        'POST login' => 'login',
                    ]
                ],
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
