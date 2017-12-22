<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use common\models\Cart;

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

	public function actionSendCart()
	{
		$request = Yii::$app->request;
		$cart = $request->post("cart");

		return $cart;
	}
}