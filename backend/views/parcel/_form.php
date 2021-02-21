<?php

use backend\models\Category;
use backend\models\Parcel;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $url Url */
/* @var $model Parcel */
?>

    <div class="parcel-form">
        <?php
        $form = ActiveForm::begin(['id' => 'form-parcel']); ?>

        <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'category_id')->dropDownList(Category::getCategories(),
            [
                'prompt' => '--- Select category ---',
            ]
        ) ?>

        <?= $form->field($model, 'recipient_id')->dropDownList(User::getUsersList(),
            [
                'prompt' => '--- Select recipient user ---',
            ]
        ) ?>

        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(
            Parcel::LIST_STATUSES,
            ['prompt' => '']
        ) ?>

        <div class="form-group">
            <?= Html::button('Save', ['class' => 'btn btn-success', 'onclick' => 'sendFormParcel(jQuery(this))']) ?>
        </div>

        <?php
        ActiveForm::end(); ?>
    </div>

<?php
$url = $model->isNewRecord ? Yii::$app->controller->action->id : Yii::$app->controller->action->id . "?id=$model->id";
$js = <<<JS
function sendFormParcel(This){
   $.ajax({
        type: 'POST',
        url: '$url',
        data: $('#form-parcel').serialize(),
        success: function () {
            $('.modal').modal('hide');
            $.pjax.reload({container:"#pjax-grid-parcel",timeout:5000});
        }
    });
}
JS;
$this->registerJs($js);
