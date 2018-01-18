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
 * @var dektrium\user\Module $module
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Token $token
 * @var bool $showPassword
 */
?>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('user', 'Hola!') ?>,
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('user', 'Su cuenta en {0} ha sido creada', Yii::$app->name) ?>.
    <?php if ($showPassword || $module->enableGeneratingPassword): ?>
        <?= Yii::t('user', 'Hemos generado una contraseña para usted') ?>: <strong><?= $user->password ?></strong>
    <?php endif ?>

</p>

<?php if ($token !== null): ?>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
        <?= Yii::t('user', 'Para completar el registro, por favor haga clic en el siguiente enlace') ?>.
    </p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
        <?= Html::a(Html::encode($token->url), $token->url); ?>
    </p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
        <?= Yii::t('user', 'Si tiene problemas, por favor, pegue la siguiente dirección URL en su navegador web') ?>.
    </p>
<?php endif ?>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('user', 'PD: Si ha recibido este correo electrónico por error, simplemente elimínelo') ?>.
</p>
