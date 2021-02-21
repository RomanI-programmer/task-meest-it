<?php

namespace common\models;

use backend\models\Category;

/**
 * This is the model class for table "parcel".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property float|null $weight
 * @property float|null $size
 * @property int $category_id
 * @property float|null $price
 * @property string|null $status
 * @property int $user_id
 * @property int $recipient_id
 *
 * @property Category $category
 * @property User $user
 */
class Parcel extends \yii\db\ActiveRecord
{

    const STATUS_SENT = 'sent';
    const STATUS_RECEIVED = 'received';
    const LIST_STATUSES = [
        'sent' => 'Sent',
        'received' => 'Received',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'parcel';
    }

    public function beforeSave($insert)
    {
       if($insert){
           $this->created_at = date('Y-m-d H:i:s');
           $this->updated_at = date('Y-m-d H:i:s');
       }

       return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['weight', 'price'], 'number'],
            [['category_id', 'user_id', 'recipient_id'], 'required'],
            [['category_id', 'user_id'], 'integer'],
            [['status', 'size'], 'string'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(),
                'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'weight' => 'Weight',
            'size' => 'Size',
            'category_id' => 'Category',
            'price' => 'Price',
            'status' => 'Status',
            'user_id' => 'Sender User',
            'recipient_id' => 'Recipient',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRecipient(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }
}
