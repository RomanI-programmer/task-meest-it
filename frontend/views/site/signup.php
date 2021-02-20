<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'email')->textInput()->widget(MaskedInput::className(),[
                    'clientOptions' => [
                        'alias' =>  'email'
                    ],
                ]) ?>

                <?= $form->field($model, 'first_name')->textInput() ?>

                <?= $form->field($model, 'last_name')->textInput() ?>

                <?= $form->field($model, 'address')->textInput() ?>

                <?= $form->field($model, 'number_phone')->widget(MaskedInput::className(),[
                    'mask' => '380999999999'
                ]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
