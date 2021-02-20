<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $dropClient = $auth->createPermission('dropClient');
        $dropClient->description = 'Drop a client';
        $auth->add($dropClient);

        $updateClient = $auth->createPermission('updateClient');
        $updateClient->description = 'Update a client';
        $auth->add($updateClient);

        $viewClient = $auth->createPermission('viewClient');
        $viewClient->description = 'View a client data';
        $auth->add($viewClient);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $dropClient);
        $auth->addChild($admin, $updateClient);
        $auth->addChild($admin, $viewClient);

        $client = $auth->createRole('client');
        $auth->add($client);
    }
}