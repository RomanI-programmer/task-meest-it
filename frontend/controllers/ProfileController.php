<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;

/**
 * Class ProfileController
 * @package frontend\controllers
 */
class ProfileController extends Controller
{

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id)
    {
        $user = User::findOne($id);

        if ($user->load(Yii::$app->request->post())) {
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Data successful saved!');
            } else {
                Yii::$app->session->setFlash('error', 'Saved error');
            }

            return $this->redirect(['edit', 'id' => $user->id]);
        }

        return $this->render('edit', [
            'user' => $user,
        ]);
    }
}
