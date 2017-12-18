<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use common\models\Category;

/**
 * Category Controller API
 *
 * @author Christian Carapezza <carapezza.christian@gmail.com>
 */
class CategoryController extends ActiveController
{
    public $modelClass = 'common\models\Category';

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

	public function actionIndex()
	{
		$category = Category::Find()
		->from('category c')
		//->select(['Category AS bookName'
		->joinWith("categories.categories cc")
		/*->joinWith("categories.categories cc")
		->joinWith("categories.categories.categories ccc")*/
		//->joinWith("categories.categories.categories.categories cccc")
		->where(["c.parent_id"=>null])
		->asArray()
		->all();
		return $category;
	}

	public function actionParent($parentid = null)
	{
		$category = Category::Find()
			->from('category c')
			->where(["c.parent_id"=>$parentid]);

		return $category->asArray()->all();
	}
}