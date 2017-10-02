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
use Da\QrCode\QrCode;
use kartik\mpdf\Pdf;

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

        $model->image_filename = 'no-image.jpg';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($uploadForm->load(Yii::$app->request->post()))
            {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if(!is_null($uploadForm->imageFile)){
                    $fileName = explode(".", $uploadForm->imageFile->name);
                    $ext = end($fileName);
                    $fileName = $model->id.".".$ext;
                    if ($uploadForm->upload($fileName, $model->id)) {
                        $model->image_filename = $model->id.'/'.$fileName;
                        $model->save();
                    }
                }
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
            if($uploadForm->load(Yii::$app->request->post()))
            {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if(!is_null($uploadForm->imageFile)){
                    $fileName = explode(".", $uploadForm->imageFile->name);
                    $ext = end($fileName);
                    $fileName = $model->id.".".$ext;
                    if ($uploadForm->upload($fileName, $model->id)) {
                        $model->image_filename = $model->id.'/'.$fileName;
                    }else{
                        $model->image_filename = 'no-image.jpg';
                    }
                    $model->save();
                }
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
                'uploadForm' => $uploadForm,
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

    private function generateHtmlQrcode($prefix, $code, $with = 100){

        $product = Product::Find()->joinWith([
            'category.parent cc' => function ($query) {
                $query->joinWith('parent p');
            },
        ])
        ->where(["code"=>$code])->one();

        $qrCode = (new QrCode($prefix.'-'.$code))
            ->setSize(250)
            ->setMargin(15)
            ->useForegroundColor(0, 0, 0);

        // now we can display the qrcode in many ways
        // saving the result to a file:
        $folderName = Yii::getAlias('@webroot').'/products-images/'.$product->id;
        if(!file_exists($folderName)){
            if(!mkdir($folderName, 0777)) {
                die('Fallo al crear las carpetas...');
            }
        }

        $qrCode->writeFile($folderName . '/code.png'); // writer defaults to PNG when none is specified

        // display directly to the browser 
        //header('Content-Type: '.$qrCode->getContentType());
        $varHtml = '<div style="width:'.$with.'%; text-align: center; float: left;">';
        $varHtml .= '<img src="' . $qrCode->writeDataUri() . '" /><br/>';
        $varHtml .= '<span style="font-size: 8px;">Código: '.$product->code.'</span><br/>';
        $varHtml .= '<span style="font-size: 8px;">Producto: '.$product->description.'</span><br/>';
        $varHtml .= '</div>';

        return $varHtml;
        //echo $qrCode->writeString();
    }

    public function actionQrcodes($code){
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
             // set mPDF properties on the fly
            'options' => ['title' => 'QR-CODES']
        ]);
        $mpdf = $pdf->api; // fetches mpdf api

        $varHtml = "<div style='with: 100%;'>";
        $qrHtml = $this->generateHtmlQrcode("PRODUCT", $code, 19);
        for ($i=0; $i < 30; $i++) { 
            $varHtml .= $qrHtml;
        }
        $varHtml .= "</div>";

        $mpdf->WriteHtml($varHtml);
        $ts = date_timestamp_get(date_create());
        echo $mpdf->Output('qr-codes-'.$ts.'.pdf', 'D');
    }

    public function actionPdfqr(){
        $this->generateProductQrPage(17505);
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
