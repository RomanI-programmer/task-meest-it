<?php

namespace common\helpers;

use yii\db\Query;

abstract class AbstractStatistics
{

    /**
     * @param array $arraySelect
     * @param int|null $userId
     * @param int|null $recipient_id
     * @return array
     */
    public function generateArrayStatisticsParcel(array $arraySelect, int $userId = null, int $recipient_id = null): array
    {
        $query =  (new Query());
        $query->select($arraySelect);
        if (!empty($userId)){
            $query->orWhere(['user_id' => $userId]);
        }
        if (!empty($recipient_id)){
            $query->orWhere(['recipient_id' => $recipient_id]);
        }
        $query->from('parcel');

        return $query->one();
    }
}
