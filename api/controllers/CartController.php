<?php

namespace api\controllers;

use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\Cors;
use api\filters\HttpBearerCdsurAuth;
use yii\rest\ActiveController;
use common\models\Cart;
use common\models\CartProducts;
use Yii;

/**
 * Cart Controller API
 *
 * @author Christian Carapezza <carapezza.christian@gmail.com>
 */
class CartController extends ActiveController
{
    public $modelClass = 'common\models\Cart';

    public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['bearerAuth'] = [
            'class' => HttpBearerCdsurAuth::className(),
            'except' => ['login', 'signup', 'options', 'confirm'],
        ];
		// add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];
        return $behaviors;
	}

    public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		//unset($actions['view']);
		return $actions;
	}

	public function actionSend()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$request = Yii::$app->request;
		$cart = $request->post("cart");

		$realCart = new Cart();
		$realCart->user_id = Yii::$app->user->identity->id;
		$realCart->save();
		
		foreach ($cart as $productRow) {
			$cartProduct = new CartProducts();
 			$cartProduct->product_id = $productRow['product']['id'];
 			$cartProduct->quantity = $productRow['quantity'];
 			$cartProduct->cart_id = $realCart->id;
 			$cartProduct->save();
		}

		return $realCart;
	}
}