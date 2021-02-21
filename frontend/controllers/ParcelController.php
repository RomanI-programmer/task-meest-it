<?php

namespace frontend\controllers;

use common\models\Parcel;
use common\models\search\ParcelSearch;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ParcelController implements the CRUD actions for Parcel model.
 */
class ParcelController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['client'],
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->session->setFlash('error', 'Sorry, access denied :(');
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Parcel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParcelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Parcel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax(
            'view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    /**
     * Creates a new Parcel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new Parcel();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $searchModel = new ParcelSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->renderAjax(
                'index',
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]
            );
        }

        return $this->renderAjax(
            'create',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Updates an existing Parcel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new ParcelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->renderAjax(
                'index',
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]
            );
        }

        return $this->renderAjax(
            'update',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Deletes an existing Parcel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->status == Parcel::STATUS_SENT || $model->status == Parcel::STATUS_RECEIVED) {
            Yii::$app->session->setFlash('warning', 'Delete is not possible because it has already been sent');

            return $this->redirect(['index']);
        }
        $model->delete();
        $searchModel = new ParcelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax(
                'index',
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]
            );
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionPrintDeclaration($id)
    {
        $parcel = $this->findModel($id);
        $qr = Text::widget(
            [
                'outputDir' => "@webroot/upload/qrcode",
                'outputDirWeb' => "@web/upload/qrcode",
                'ecLevel' => QRcode::QR_ECLEVEL_L,
                'text' => Url::to(['parcel/view', 'id' => $id], true),
                'size' => 6,
            ]
        );

        return $this->render('print-declaration', [
            'qr' => $qr,
            'parcel' => $parcel,
        ]);
    }

    /**
     * Finds the Parcel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Parcel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parcel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
