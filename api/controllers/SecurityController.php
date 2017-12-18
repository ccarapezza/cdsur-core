<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;
use common\models\Category;
use dektrium\user\models\LoginForm;
use yii\filters\auth\HttpBearerAuth;
use Yii;
/**
 * Category Controller API
 *
 * @author Christian Carapezza <carapezza.christian@gmail.com>
 */
class SecurityController extends Controller
{
    /**
     * List of allowed domains.
     * Note: Restriction works only for AJAX (using CORS, is not secure).
     *
     * @return array List of domains, that can access to this API
     */
    public static function allowedDomains()
    {
        return [
            '*',                        // star allows all domains
            'http://localhost:8100',
            //'http://test2.example.com',
        ];
    }

    public function behaviors()
	{
        $behaviors = array();

        $behaviors['bearerAuth'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['login', 'options'],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['login', 'user-info'],
            'rules' => [
                [
                    'actions' => ['login',],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['user-info'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'verbs' => ['OPTIONS']
                ],
            ],
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

    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = \Yii::createObject(LoginForm::className());
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            throw new \yii\web\HttpException(403, 'Username or password is incorrect.');
        }
    }

    public function actionUserInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ArrayHelper::toArray(Yii::$app->user->identity, [
            'dektrium\user\models\User' => [
                'username',
                'email'
            ],
        ]);;
    }

    public function actionOptions()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return true;
    }
}