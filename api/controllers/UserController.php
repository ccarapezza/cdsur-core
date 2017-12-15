<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use common\models\Category;
use dektrium\user\models\LoginForm;
use Yii;
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
	    $behaviors['authenticator'] = [
	        'class' => HttpBasicAuth::className(),
	    ];
	    return $behaviors;

	    return ArrayHelper::merge([
	    	'access' => [
                'class' => AccessControl::className(),
                'only' => ['login'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
	        [
	            'class' => Cors::className(),
	            /*'cors' => [
	                'Access-Control-Allow-Origin' => '*',
	            ],*/
	        ],
	        [
	            'class' => HttpBasicAuth::className(),
	        ],
	    ], parent::behaviors());
	}

    public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		unset($actions['view']);
		unset($actions['create']);
		unset($actions['update']);
		unset($actions['delete']);
		return $actions;
	}

	/**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        return Yii::$app->user->identity;
    }

}