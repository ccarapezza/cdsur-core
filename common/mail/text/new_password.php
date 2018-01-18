<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var dektrium\user\Module          $module
 * @var dektrium\user\models\User     $user
 * @var dektrium\user\models\Password $password
 */

?>
<?= Yii::t('user', 'Hola!') ?>,
<?= Yii::t('user', 'Su cuenta en {0} tiene una nueva contraseña', Yii::$app->name) ?>.
<?= Yii::t('user', 'Hemos generado una contraseña para usted') ?>: <strong><?= $user->password ?></strong>
<?= Yii::t('user', 'PD: Si ha recibido este correo electrónico por error, simplemente elimínelo') ?>.