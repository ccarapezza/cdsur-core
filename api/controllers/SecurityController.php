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
class SecurityController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
	{
	    return ArrayHelper::merge([
	    	'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'secured'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['secured'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
	        [
	            'class' => Cors::className(),
	            'cors' => [
	                'Access-Control-Allow-Credentials' => true,
	                'Access-Control-Allow-Origin' => '*',
	                'Access-Control-Max-Age' => 3600,
	            ],
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
        $model = \Yii::createObject(LoginForm::className());
        $model->login = Yii::$app->request->post('username');
        $model->password = Yii::$app->request->post('password');

        if ($model->login()) {
            return Yii::$app->user->identity;
        } else {
            throw new \yii\web\HttpException(400, 'Bad request.');
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionSecured()
    {
    	return "OK!!";
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $request = Yii::$app->request;

		$email = $request->get('email');
		$username = $request->get('username');
		$password = $request->get('password');

        if (isset($email) && isset($username) && isset($password)) {
        	$model->email = $email;
			$model->username = $username;
			$model->password = $password;

            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}