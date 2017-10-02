<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\rest\ActiveController;
use common\models\Product;
use Yii;
/**
 * Product Controller API
 *
 * @author Christian Carapezza <carapezza.christian@gmail.com>
 */
class ProductController extends ActiveController
{
    public $modelClass = 'common\models\Product';

    public function behaviors()
	{
	    return ArrayHelper::merge([
	        [
	            'class' => Cors::className()
	        ],
	    ], parent::behaviors());
	}

    public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		return $actions;
	}

	public function actionIndex()
	{
		$request = Yii::$app->request;
		$categoryId = $request->get("categoryId");

		$products = Product::Find()->joinWith([
		    'category.parent cc' => function ($query) {
		        $query->joinWith('parent p');
		    },
		]);

		if(isset($categoryId)){
			$products->where(["category.id"=>$categoryId]);
		}
		
		return $products->asArray()->all();
	}
}