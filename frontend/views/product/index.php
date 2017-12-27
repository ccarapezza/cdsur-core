<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Producto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="post-search">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'post',
        ]); ?>

        <h3>Buscar productos</h3>
        <div class="form-group col-md-6">
            <?= $form->field($model, 'code') ?>
        </div>

        <div class="form-group col-md-6">
            <?= $form->field($model, 'description') ?>
        </div>

        <div class="form-group" style="text-align: right;">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Limpiar', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'code',
            'description',
            'category.parent.parent.name:raw:Categoria 1',
            'category.name:raw:Categoria 2',
            'category.parent.name:raw:Categoria 3',
            [
                'attribute' => 'Image',
                'format' => 'raw',
                'value' => function ($model) {   
                    if ($model->image_filename!='')
                        return '<img src="'.str_replace("index.php", "", Yii::$app->homeUrl).'/products-images/'.$model->image_filename.'" width="50px" height="auto">'; else return 'no image';
                },
                'label' => 'Imagen',
            ],
            [
                'attribute' => 'Image',
                'format' => 'raw',
                'value' => function ($model) {   
                    return Html::a('<span class="glyphicon glyphicon-qrcode"></span>', ['qrcodes', 'code' => $model->code], ['class' => 'btn btn-success']);
                },
                'label' => 'Imagen',
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
