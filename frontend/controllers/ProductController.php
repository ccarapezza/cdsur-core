<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\Category;
use frontend\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $uploadForm = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
            if(isset($uploadForm->imageFile))
            {
                $fileName = $model->id.".jpg";
                if ($uploadForm->upload($fileName, $model->id)) {
                    $model->image_filename = $model->id.'/'.$fileName;
                }else{
                    $model->image_filename = 'no-image.jpg';
                }
                $model->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
                'uploadForm' => $uploadForm,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $uploadForm = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(isset($uploadForm->imageFile))
            {
                $fileName = $model->id.".jpg";
                if ($uploadForm->upload($fileName, $model->id)) {
                    $model->image_filename = $model->id.'/'.$fileName;
                }else{
                    $model->image_filename = 'no-image.jpg';
                }
                $model->save();
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
