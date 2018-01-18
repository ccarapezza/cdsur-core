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
 * @var dektrium\user\models\Token $token
 */
?>
<?= Yii::t('user', 'Hola!') ?>,
<?= Yii::t(
    'user',
    'Recientemente ha solicitado un cambio de correo electrónico en {0}',
    Yii::$app->name
) ?>.
<?= Yii::t('user', 'Para completar la petición, haga clic en el siguiente enlace') ?>.
<?= Html::a(Html::encode($token->getUrl()), $token->getUrl()); ?>
<?= Yii::t('user', 'Si tiene problemas, por favor, pegue la siguiente dirección URL en su navegador web') ?>.
<?= Yii::t('user', 'PD: Si ha recibido este correo electrónico por error, simplemente elimínelo') ?>.