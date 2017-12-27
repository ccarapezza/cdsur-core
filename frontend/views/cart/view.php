<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Cart */

$this->title = 'Pedido Nº '.$model->id;
?>
<div class="cart-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=($model->status == 'PENDING') ? '<div class="alert alert-success" role="alert">Estado: <b>PENDIENTE</b></div>' : '<div class="alert alert-danger" role="alert">Estado: <b>FINALIZADO</b></div>'; ?>
    
    <h2>Datos del cliente</h2>
    <?= DetailView::widget([
        'model' => $model->getUser()->one(),
        'attributes' => [
            [
                'attribute' => 'email',
                'label' => 'E-mail',
            ],
            [
                'attribute' => 'username',
                'label' => 'Usuario',
            ],
        ],
    ]) ?>

    <h2>Productos</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "Mostrando {begin} - {end} de {totalCount} items",
        'columns' => [
            [
                'attribute' => 'product.code',
                'label' => 'Código',
            ],
            [
                'attribute' => 'product.description',
                'label' => 'Descripción',
            ],
            [
                'attribute' => 'quantity',
                'label' => 'Cantidad',
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar pedido', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar el pedido?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-save-file"></span> Generar PDF', ['generate-pedido-pdf', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
        <?= ($model->status == 'PENDING') ? Html::a('<span class="glyphicon glyphicon-ok"></span> Finalizar pedido', ['finalize-pedido-with-pdf-gen', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Desea finalizar el pedido?',
                'method' => 'post',
            ],
        ]):''; ?>
    </p>

</div>
