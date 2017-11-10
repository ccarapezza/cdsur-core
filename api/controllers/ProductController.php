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
	    return [
	        'corsFilter' => [
	            'class' => Cors::className(),
	            'cors' => [
	                // restrict access to
	                'Origin' => ['http://localhost:8100'],
	                'Access-Control-Request-Method' => ['POST', 'PUT', 'OPTIONS' ],
	                // Allow only POST and PUT methods
	                'Access-Control-Request-Headers' => ['X-Wsse'],
	                // Allow only headers 'X-Wsse'
	                'Access-Control-Allow-Credentials' => true,
	                // Allow OPTIONS caching
	                'Access-Control-Max-Age' => 3600,
	                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
	                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
	            ],

	        ],
	    ];
	}

    /*public function behaviors()
	{
	    return ArrayHelper::merge([
	        [
	            'class' => Cors::className(),
	            'cors' => [
	                'Access-Control-Allow-Credentials' => true,
	                'Access-Control-Allow-Origin' => '*',
	                'Access-Control-Max-Age' => 3600,
	            ],
	        ],
	    ], parent::behaviors());
	}*/

    public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		unset($actions['view']);
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

	public function actionView($id)
	{
		$request = Yii::$app->request;

		$products = Product::Find()->joinWith([
		    'category.parent cc' => function ($query) {
		        $query->joinWith('parent p');
		    },
		]);
		$products->where(["product.id"=>$id]);

		return $products->asArray()->one();
	}

	public function actionCode($code)
	{
		$request = Yii::$app->request;

		$products = Product::Find()->joinWith([
		    'category.parent cc' => function ($query) {
		        $query->joinWith('parent p');
		    },
		]);
		$products->where(["product.code"=>$code]);

		return $products->asArray()->one();
	}

	public function actionSearch()
	{
		$request = Yii::$app->request;
		$code = $request->get('code');
		$description = $request->get('description');

		$products = Product::Find()->joinWith([
		    'category.parent cc' => function ($query) {
		        $query->joinWith('parent p');
		    },
		]);

		if(isset($code)){
			$products->where(['product.code'=>$code]);
		}else{
			$products->where(['like', 'product.description', [$description]]);
		}

		return $products->asArray()->all();
	}

	public function actionSearchpost()
	{
		$request = Yii::$app->request;
		$code = $request->post('code');
		$description = $request->post('description');

		$products = Product::Find()->joinWith([
		    'category.parent cc' => function ($query) {
		        $query->joinWith('parent p');
		    },
		]);

		if(isset($code)){
			$products->where(['product.code'=>$code]);
		}else{
			$products->where(['like', 'product.description', [$description]]);
		}

		return $products->asArray()->all();
	}
}