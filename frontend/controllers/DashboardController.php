<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;

class DashboardController extends Controller
{

    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'statistic' => self::generateArrayStatisticsParcel(),
            ]
        );
    }

    /**
     * @return array|bool
     */
    public static function generateArrayStatisticsParcel()
    {
        return (new Query())
            ->select(
                [
                    'SUM( IF(status = "sent", 1, 0) ) AS sent',
                    'SUM( IF(status = "received", 1, 0) ) AS received',
                ]
            )
            ->andWhere(['user_id' => Yii::$app->user->getId()])
            ->from('parcel')
            ->one();
    }
}