<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Parcel;

/**
 * ParcelSearch represents the model behind the search form of `common\models\Parcel`.
 */
class ParcelSearch extends Parcel
{
    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        return [
            [['id', 'category_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at', 'status'], 'safe'],
            [['size'],'string'],
            [['weight', 'price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Parcel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'DATE(created_at)' => $this->created_at,
            'DATE(updated_at)' => $this->updated_at,
            'weight' => $this->weight,
            'size' => $this->size,
            'category_id' => $this->category_id,
            'price' => $this->price,
        ]);

        $query->andWhere([
            'or',
            ['user_id' => empty($this->user_id) ? Yii::$app->user->getId() : $this->user_id],
            ['recipient_id' => Yii::$app->user->getId()],
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
