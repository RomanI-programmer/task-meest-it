<?php

namespace frontend\controllers;

use common\helpers\DashboardHelper;
use Yii;
use yii\web\Controller;

/**
 * Class DashboardController
 * @package frontend\controllers
 */
class DashboardController extends Controller
{
    public function actionIndex()
    {
        $statistic = new DashboardHelper();
        $arraySum = [
            'SUM( IF(status = "sent", 1, 0) ) AS sent',
            'SUM( IF(status = "received", 1, 0) ) AS received',
        ];
        $userID = Yii::$app->user->getId();

        return $this->render(
            'index',
            [
                'statistic' => $statistic->generateArrayStatisticsParcel($arraySum,$userID,$userID),
            ]
        );
    }
}