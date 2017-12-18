<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\rest\ActiveController;
use common\models\Category;
use common\models\LoginForm;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
/**
 * Category Controller API
 *
 * @author Christian Carapezza <carapezza.christian@gmail.com>
 */
class UserController extends ActiveController
{
    public $modelClass = 'dektrium\user\models\User';

    public function behaviors()
	{
		$behaviors = parent::behaviors();
		/*$behaviors['authenticator'] = [
		    'class' => HttpBearerAuth::className(),
		];*/
		$behaviors['contentNegotiator'] = [
		    'class' => ContentNegotiator::className(),
		    'formats' => [
		        'application/json' => Response::FORMAT_JSON,
		    ],
		];
		$behaviors['access'] = [
		    'class' => AccessControl::className(),
		    'only' => ['test'],
		    'rules' => [
		        [
		            'actions' => ['test'],
		            'allow' => true,
		            'roles' => ['?'],
		        ],
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

	public function actionTest()
	{
		return "HOLA TEST!!!!!";
	}
}