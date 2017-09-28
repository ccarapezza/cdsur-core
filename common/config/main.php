<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
	        'identityClass' => 'dektrium\user\models\User',
	        'loginUrl' => ['admin/user/login'],
	    ]
    ],
    'modules' => [
	    'user' => [
	        'class' => 'dektrium\user\Module',
	    ],
	],
];
