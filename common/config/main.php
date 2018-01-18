<?php
return [
    'name' => 'CDSur-App',
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
          'admins' => ['administrador'],
          'mailer' => [
            'welcomeSubject'        => 'Bienvenido a CDSur-App',
            'confirmationSubject'   => 'Confime su cuenta en CDSur-App',
            'reconfirmationSubject' => 'Confirme su cambio de correo electrónico en CDSur-App',
            'recoverySubject'       => 'Restablecimiento de contraseña completada en CDSur-App',
            'newPasswordSubject'    => 'Su constraseña en CDSur-App ha cambiado',
          ],
	    ],
	],
];
