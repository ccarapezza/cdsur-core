<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\CartStatus;
use common\models\CartProducts;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
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
     * Lists all Cart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Cart::find();
        $query->joinWith(['cartProducts']);
        $pendingCartsdataProvider = new ActiveDataProvider([
            'query' => $query->where(['status'=>CartStatus::Pending]),
        ]);

        $query = Cart::find();
        $query->joinWith(['cartProducts']);
        $finalizedCartsdataProvider = new ActiveDataProvider([
            'query' => $query->where(['status'=>CartStatus::Finalized]),
        ]);

        return $this->render('index', [
            'pendingCartsdataProvider' => $pendingCartsdataProvider,
            'finalizedCartsdataProvider' => $finalizedCartsdataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $query = CartProducts::find();
        $query->where(['cart_id'=>$id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cart model.
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
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionFinalizePedidoWithPdfGen($id)
    {
        $model = $this->findModel($id);
        $model->status = CartStatus::Finalized;
        if($model->save()){
            $this->actionGeneratePedidoPdf($id);
        }
    }

    public function actionGeneratePedidoPdf($id)
    {
        $model = $this->findModel($id);

        $pdfTemplate =  $this->renderPartial('pedido', [
            'model' => $model,
        ]);

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
            'options' => ['title' => 'Pedido N-'.$id]
        ]);
        $mpdf = $pdf->api; // fetches mpdf api
        $mpdf->WriteHtml($pdfTemplate);
        $ts = date_timestamp_get(date_create());

        echo $mpdf->Output('pedido-'.$id.'-'.$ts.'.pdf', 'D');
    }
}
