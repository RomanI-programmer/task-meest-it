<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\MaskedInput;

/** @var \common\models\User $user */

?>

<?php
$form = ActiveForm::begin();
?>

<?= $form->field($user, 'first_name')->textInput() ?>

<?= $form->field($user, 'last_name')->textInput() ?>

<?= $form->field($user, 'email')->textInput()->widget(MaskedInput::className(),[
    'clientOptions' => [
        'alias' => 'email',
    ],
]) ?>

<?= $form->field($user, 'address')->textInput() ?>

<?= $form->field($user, 'number_phone')->widget(MaskedInput::className(),[
    'mask' => '380999999999'
]) ?>

<?= Html::submitButton('Save',['class' => 'btn btn-success']) ?>

<?php
ActiveForm::end();