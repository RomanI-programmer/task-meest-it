<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use hosannahighertech\lbootstrap\widgets\NavBar;
use hosannahighertech\lbootstrap\widgets\SideBar;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $this->head() ?>
</head>
<body>
<?php
$this->beginBody() ?>

<div class="wrapper">

    <?= SideBar::widget(
        [
            //'bgImage' => '@web/img/sidebar-5.jpg', //Don't define it if there is none
            'header' => [
                'title' => 'Meest IT',
                'url' => ['/default/index']
            ],
            'links' => [
                ['title' => 'Users', 'url' => ['/management-user/index'], 'icon' => 'users'],
                ['title' => 'Parcel', 'url' => ['/parcel/index'], 'icon' => 'box1'],
                ['title' => 'Categories', 'url' => ['/category/index'], 'icon' => 'menu'],
                [
                    'title' => 'Log Out',
                    'url' => ['/site/logout'],
                    'icon' => 'door-lock',
                    'options' => ['data' => ['method' => 'post']]
                ],
            ]
        ]
    ) ?>

    <div class="main-panel">
        <?= NavBar::widget(
            [
                'theme' => 'red',
                'brand' => [
                    'label' => ''
                ],
                'links' => [
                    ['label' => 'Welcome, ' . Yii::$app->user->identity->email],
//                    ['label' => 'About', 'url' => ['/site/about']],
                ],
            ]
        ) ?>

        <div class="content">
            <div class="container-fluid">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">

        </footer>

    </div>
</div>

<?php
$this->endBody() ?>
</body>
</html>
<?php
$this->endPage() ?>
