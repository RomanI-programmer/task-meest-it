<?php

namespace backend\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $name
 * @property string|null $description
 *
 * @property Parcel[] $parcels
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Parcels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParcels(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Parcel::className(), ['category_id' => 'id']);
    }

    /**
     * Method for get all Categories
     * @return array
     */
    public static function getCategories(): array
    {
        return ArrayHelper::map(self::find()->all(),'id','name');
    }
}
