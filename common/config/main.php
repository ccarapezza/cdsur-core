<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
	        'identityClass' => 'common\models\User',
        ],
        'view' => [
          'theme' => [
              'pathMap' => [
                  '@dektrium/user/views/mail' => '@common/mail'
              ],
          ],
        ],
    ],
    'modules' => [
	    'user' => [
	        'class' => 'dektrium\user\Module',
	    ],
	],
];
