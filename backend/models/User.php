<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 * @property string|null $last_name
 * @property string|null $first_name
 * @property string|null $address
 * @property int|null $number_phone
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @param $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['auth_key', 'password_hash', 'email'], 'required'],
            [['created_at', 'updated_at',],'safe'],
            [['auth_key'], 'string', 'max' => 32],
            [['number_phone'], 'string', 'max' => 12],
            [['password_hash', 'password_reset_token', 'email', 'verification_token', 'last_name', 'first_name', 'address'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'address' => 'Address',
            'number_phone' => 'Number Phone',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): User
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User
     */
    public static function findByUsername(string $username): User
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @param string $email
     * @return User
     */
    public static function findByEmail(string $email): User
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token): ?User
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken(string $token): ?User
    {
        return static::findOne([
            'verification_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword(string $password): self
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);

        return $this;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * @param string $numberPhone
     * @return $this
     */
    public function setNumberPhone(string $numberPhone): self
    {
        $this->number_phone = $numberPhone;

        return $this;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey(): self
    {
        $this->auth_key = Yii::$app->security->generateRandomString();

        return $this;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken(): self
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();

        return $this;
    }

    /**
     * Generates new token for email verification
     *
     */
    public function generateEmailVerificationToken(): self
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();

        return $this;
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Gets query for [[Parcels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParcels(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Parcel::className(), ['user_id' => 'id']);
    }

    /**
     * Method get all users
     * @return array
     */
    public static function getUsersList(): array
    {
        return ArrayHelper::map(User::find()->all(),'id', function ($data) {
            return $data->first_name . ' ' . $data->last_name;
        });
    }
}
