<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;
use common\models\Category;
use dektrium\user\models\User;
use dektrium\user\models\LoginForm;
use dektrium\user\models\RegistrationForm;
use api\filters\HttpBearerCdsurAuth;
use Yii;

/**
 * Security Controller API
 *
 * @author Christian Carapezza <carapezza.christian@gmail.com>
 */
class SecurityController extends Controller
{
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['bearerAuth'] = [
            'class' => HttpBearerCdsurAuth::className(),
            'except' => ['login', 'signup', 'options', 'confirm'],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['login', 'signup', 'confirm', 'user-info', 'test'],
            'rules' => [
                [
                    'actions' => ['login', 'signup', 'confirm'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['user-info', 'test'],
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

    public function actionSignup()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = \Yii::createObject(RegistrationForm::className());
        $request = Yii::$app->request;

        $email = $request->post('email');
        $username = $request->post('username');
        $password = $request->post('password');

        if (isset($email) && isset($username) && isset($password)) {
            $model->email = $email;
            $model->username = $username;
            $model->password = $password;
            
            if ($model->register()) {
                return "Register OK!";
            }
        }

        throw new \yii\web\HttpException(403, 'Username or password is incorrect.');

        //throw new \yii\web\HttpException(400, 'Bad request.');
    }

    public function actionConfirm($id, $code)
    {
        $user = User::FindOne($id);
        if($user->attemptConfirmation($code))
            return 'User has been confirmed';
        else
            throw new \yii\web\HttpException(400, 'Confirmation is not valid.');
    }

    public function actionOptions()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return true;
    }

    public function actionTest()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Yii::$app->request->headers;
    }
} 