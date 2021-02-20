<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use yii\helpers\BaseConsole;

/**
 * Class AdministratorController
 * @package console\controllers
 */
class AdministratorController extends Controller
{

    /**
     * Method for created administrator users with console.
     */
    public function actionNewAdmin()
    {
        $email = BaseConsole::input("Enter email: ");
        $password = BaseConsole::input("Enter password");
        try {
            if (empty($password) || empty($email)) {
                throw new \Exception('Data is empty');
            }
            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            $user->generateEmailVerificationToken();
            if ($user->save()) {
                die('Administrator successful created!');
            } else {
                throw new \Exception('Validation user error!');
            }
        } catch (\Exception $exception) {
            die($exception->getMessage());
        }
    }
}
