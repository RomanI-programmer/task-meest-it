<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $email;
    public $password;
    public $last_name;
    public $first_name;
    public $number_phone;
    public $address;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['last_name', 'trim'],
            ['last_name', 'required'],
            ['last_name', 'string', 'max' => 255],

            ['first_name', 'trim'],
            ['first_name', 'required'],
            ['last_name', 'string', 'max' => 255],

            ['number_phone', 'required'],
            ['number_phone', 'string'],

            ['address', 'required'],
            ['address', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->setEmail($this->email)
            ->setPassword($this->password)
            ->setLastName($this->last_name)
            ->setFirstName($this->first_name)
            ->setNumberPhone($this->number_phone)
            ->setAddress($this->address)
            ->generateAuthKey()
            ->generateEmailVerificationToken()
            ->generatePasswordResetToken();

        if($user->save()){
            Yii::$app->user->login($user,  3600 * 24 * 30);

            return true;
        }
        echo '<pre>';
        print_r($user->errors);
        echo '</pre>';
        die();
        return false;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
