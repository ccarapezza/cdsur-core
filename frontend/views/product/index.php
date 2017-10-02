<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
