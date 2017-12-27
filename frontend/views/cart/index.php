<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pedidos';
$columns = [
            [
                'label' =>   'N°',
                'attribute' => 'id',
            ],
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
                'format' => 'raw',
                'label' => 'Fecha',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->created_date, 'dd/MM/yy - <b>HH:mm</b>');
                },
            ],
            
        ];
?>
<div class="cart-index">

    <h2><?= Html::encode($this->title) ?> Pendientes</h2>

    <?= GridView::widget([
        'dataProvider' => $pendingCartsdataProvider,
        'columns' => array_merge($columns,[
            [
                'label' => 'Acciones',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('<img class="custom-icon" src="pdf-icon.png">', ['cart/generate-pedido-pdf', 'id' => $model->id], ['class' => 'btn btn-default custom-button btn-sm']).Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data' => [
                        'confirm' => 'Está seguro que desea eliminar el pedido?',
                        'method' => 'post',
                    ]]).Html::a('<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;<span class="glyphicon glyphicon-ok"></span>', ['view', 'id' => $model->id], ['class' => 'btn btn-success btn-sm']);
                },
                'contentOptions' =>function ($model, $key, $index, $column){
                    return [
                        'class' => 'action-cell'
                    ];
                },
            ],
        ]),
        'emptyText' => 'No hay pedidos.'
    ]); ?>
    <hr/>
    <h2><?= Html::encode($this->title) ?> Finalizados</h2>
    <?= GridView::widget([
        'dataProvider' => $finalizedCartsdataProvider,
        'columns' => array_merge($columns,[
            [
                'label' => 'Acciones',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('<img class="custom-icon" src="pdf-icon.png">', ['cart/generate-pedido-pdf', 'id' => $model->id], ['class' => 'btn btn-default custom-button btn-sm']).Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data' => [
                        'confirm' => 'Está seguro que desea eliminar el pedido?',
                        'method' => 'post',
                    ]]).Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                },
                'contentOptions' =>function ($model, $key, $index, $column){
                    return [
                        'class' => 'action-cell'
                    ];
                },
            ],
        ]),
        'emptyText' => 'No hay pedidos.'
    ]); ?>
</div>
