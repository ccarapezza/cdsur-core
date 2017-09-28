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
class CategoryController extends ActiveController
{
    public $modelClass = 'common\models\Category';

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