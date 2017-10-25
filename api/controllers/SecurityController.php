<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\rest\ActiveController;
use common\models\Category;
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
	        [
	            'class' => Cors::className()
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
        	$model
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