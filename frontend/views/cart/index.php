<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $pendingCartsdataProvider,
        'columns' => [
            'id',
            [
                'label' =>   'Usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    $count = 0;
                    foreach ($model->cartProducts as $cartProduct) {
                        $count += $cartProduct->quantity;
                    }
                    return ('<b>'.$model->user->username.'</b> ('.$model->user->email.')');
                },
            ],
            [
                'attribute' =>   'status',
                'label' => 'Estado',
            ],
            [
                'label' =>   'Productos',
                'format' => 'raw',
                'value' => function ($model) {
                    return count($model->cartProducts);
                },
            ],
            [
                'label' =>   'Productos Totales',
                'format' => 'raw',
                'value' => function ($model) {
                    $count = 0;
                    foreach ($model->cartProducts as $cartProduct) {
                        $count += $cartProduct->quantity;
                    }
                    return ($count);
                },
            ],
            [
                'attribute' =>   'updated_date',
                'format' => 'datetime',
                'label' => 'Fecha',
            ],
            [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Procesar Pedido', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $finalizedCartsdataProvider,
        'columns' => [
            'id',
            'user.username',
            'user.email',
            'status',
            [
                'label' =>   'Productos',
                'format' => 'raw',
                'value' => function ($model) {
                    return count($model->cartProducts);
                },
            ],
            [
                'attribute' =>   'cartProducts',
                'format' => 'raw',
                'value' => function ($model) {
                    $count = 0;
                    foreach ($model->cartProducts as $cartProduct) {
                        $count += $cartProduct->quantity;
                    }
                    return ($count);
                },
            ],
            'updated_date:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
