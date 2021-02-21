<?php

namespace backend\controllers;

use common\helpers\DashboardHelper;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DashboardController extends Controller
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
                        'roles' => ['admin'],
                        'denyCallback' => function($rule, $action) {
                            Yii::$app->session->setFlash('error','Sorry, access denied :(');
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $statistic = new DashboardHelper();
        $arraySum = [
            'SUM( IF(status = "sent", 1, 0) ) AS sent',
            'SUM( IF(status = "received", 1, 0) ) AS received',
        ];

        return $this->render(
            'index',
            [
                'statistic' => $statistic->generateArrayStatisticsParcel($arraySum),
            ]
        );
    }
}